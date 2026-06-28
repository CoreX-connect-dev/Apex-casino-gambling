'use strict';
app.controller('gamePageCtrl',['$scope','$timeout',function($scope,$timeout){
  $scope.gameLoaded=false; $scope.fullscreen=false;
  $scope.onGameLoad=function(){$scope.$apply(function(){$scope.gameLoaded=true;});};
  $scope.toggleFullscreen=function(){
    var el=document.getElementById('game-frame-wrapper'); if(!el)return;
    if(!document.fullscreenElement){el.requestFullscreen&&el.requestFullscreen();$scope.fullscreen=true;}
    else{document.exitFullscreen&&document.exitFullscreen();$scope.fullscreen=false;}
  };
  window.addEventListener('message',function(event){
    if(!event.data)return;
    try{var msg=typeof event.data==='string'?JSON.parse(event.data):event.data;
      if(msg.type==='balance_update'&&msg.balance!==undefined){$scope.$apply(function(){document.querySelectorAll('.balanceValue').forEach(function(el){el.textContent=parseFloat(msg.balance).toFixed(2);});});}
    }catch(e){}
  });
}]);
