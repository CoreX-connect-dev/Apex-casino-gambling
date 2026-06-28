'use strict';
var app = angular.module('app', ['angularLazyImg']);
function LPConfig() { this.heroOptions=function(){}; this.gameOptions=function(){}; }
app.controller('gameCtrl', ['$scope','$timeout','$window', function($scope,$timeout,$window) {
  $scope.activeModal = null;
  $scope.openModal = function($event, selector) {
    if ($event) $event.preventDefault();
    $scope.closeAllModals();
    var target = selector || ($event && $event.currentTarget.dataset.name);
    if (!target) return;
    var el = document.querySelector('[data-name="'+target+'"]') || document.querySelector('.'+target) || document.querySelector('#'+target.replace('#',''));
    if (el) { el.classList.add('active'); el.style.display='flex'; document.body.classList.add('locked'); }
    $scope.activeModal = target;
  };
  $scope.closeModal = function($event) { if ($event) $event.preventDefault(); $scope.closeAllModals(); };
  $scope.close = function($event) { $scope.closeModal($event); };
  $scope.$close = function() { $scope.closeAllModals(); };
  $scope.closeAllModals = function() {
    document.querySelectorAll('.modal,.popup,.frame__cont_log,.frame__cont_reg').forEach(function(m){m.classList.remove('active');m.style.display='none';});
    document.body.classList.remove('locked');
    $scope.activeModal = null;
  };
  document.addEventListener('click', function(e) {
    var btn = e.target.closest('[data-name]');
    if (btn && btn.dataset.name) { e.preventDefault(); $scope.$apply(function(){$scope.openModal(null,btn.dataset.name);}); }
    if (e.target.classList.contains('overlay')||e.target.id==='lock__screen') { $scope.$apply(function(){$scope.closeAllModals();}); }
    if (e.target.closest('.close-pop,.close-btn,.js-close-popup,.modal-close')) { $scope.$apply(function(){$scope.closeAllModals();}); }
  });
  document.addEventListener('keydown', function(e) { if(e.key==='Escape') $scope.$apply(function(){$scope.closeAllModals();}); });
  $scope.sendForm = function($event) {
    if (!$event) return;
    var form = $event.target; var btn = form.querySelector('[type=submit]');
    if (btn) btn.disabled = true;
    fetch(form.action, {method:'POST',body:new FormData(form),headers:{'X-Requested-With':'XMLHttpRequest'}})
    .then(function(r){return r.json();}).then(function(data){
      if (btn) btn.disabled = false;
      if (data.redirect) { window.location.href=data.redirect; return; }
      if (data.success) { window.location.reload(); return; }
      if (data.error||data.errors) {
        var msg = data.error||Object.values(data.errors||{}).flat().join('\n');
        $scope.showNotification(msg,'error');
      }
    }).catch(function(){ if(btn) btn.disabled=false; $scope.showNotification('Request failed. Try again.','error'); });
  };
  $scope.showNotification = function(msg, type) {
    var el = document.createElement('div');
    var bg = type==='success'?'#27ae60':type==='warning'?'#f39c12':'#e74c3c';
    el.style.cssText='position:fixed;top:20px;right:20px;z-index:9999;padding:12px 20px;border-radius:8px;background:'+bg+';color:#fff;font-size:.9rem;box-shadow:0 4px 12px rgba(0,0,0,.4);max-width:320px;word-wrap:break-word';
    el.innerText = msg; document.body.appendChild(el); setTimeout(function(){el.remove();},5000);
  };
  $scope.pollBalance = function() {
    if (!window.__authUser) return;
    $timeout(function() {
      var meta = document.querySelector('meta[name=csrf-token]');
      if (!meta) return;
      fetch('/profile/ajax',{method:'POST',headers:{'X-CSRF-TOKEN':meta.content,'X-Requested-With':'XMLHttpRequest','Content-Type':'application/json'},body:JSON.stringify({action:'balance'})})
      .then(function(r){return r.json();}).then(function(data){
        if(data.balance!==undefined){
          document.querySelectorAll('.balanceValue').forEach(function(el){el.textContent=data.balance+' '+(data.currency||'');});
          document.querySelectorAll('.bonusValue').forEach(function(el){el.textContent=(data.bonus||'0.00')+' '+(data.currency||'');});
        }
      }).catch(function(){}).finally(function(){$scope.pollBalance();});
    }, 30000);
  };
  $scope.pollBalance();
}]);
$(document).ready(function() {
  $(document).on('click','.hamburger,.mobile-menu-toggle',function(){$('.mobile-menu').toggleClass('active');$('body').toggleClass('locked');});
  var meta=document.querySelector('meta[name=csrf-token]');
  if(meta) $.ajaxSetup({headers:{'X-CSRF-TOKEN':meta.content}});
});
