-- Full schema for apex-bet casino app
-- Run this in Railway MySQL Console

CREATE TABLE IF NOT EXISTS shops (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255),
  balance DECIMAL(15,2) DEFAULT 0,
  percent DECIMAL(5,2) DEFAULT 0,
  max_win DECIMAL(15,2) DEFAULT 0,
  frontend VARCHAR(255),
  password VARCHAR(255),
  currency VARCHAR(20) DEFAULT 'USD',
  shop_limit DECIMAL(15,2) DEFAULT 0,
  is_blocked TINYINT DEFAULT 0,
  orderby INT DEFAULT 0,
  user_id BIGINT,
  pending DECIMAL(15,2) DEFAULT 0,
  access VARCHAR(255),
  country VARCHAR(10),
  os VARCHAR(50),
  device VARCHAR(50),
  rules_terms_and_conditions TEXT,
  rules_privacy_policy TEXT,
  rules_general_bonus_policy TEXT,
  rules_why_bitcoin TEXT,
  rules_responsible_gaming TEXT,
  happyhours_active TINYINT DEFAULT 0,
  progress_active TINYINT DEFAULT 0,
  invite_active TINYINT DEFAULT 0,
  welcome_bonuses_active TINYINT DEFAULT 0,
  sms_bonuses_active TINYINT DEFAULT 0,
  wheelfortune_active TINYINT DEFAULT 0,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS games (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255),
  title VARCHAR(255),
  shop_id BIGINT,
  jpg_id BIGINT,
  label VARCHAR(255),
  device VARCHAR(50),
  gamebank VARCHAR(255),
  chanceFirepot1 DECIMAL(10,4) DEFAULT 0,
  chanceFirepot2 DECIMAL(10,4) DEFAULT 0,
  chanceFirepot3 DECIMAL(10,4) DEFAULT 0,
  fireCount1 INT DEFAULT 0,
  fireCount2 INT DEFAULT 0,
  fireCount3 INT DEFAULT 0,
  lines_percent_config_spin TEXT,
  lines_percent_config_spin_bonus TEXT,
  lines_percent_config_bonus TEXT,
  lines_percent_config_bonus_bonus TEXT,
  rezerv DECIMAL(15,2) DEFAULT 0,
  cask DECIMAL(15,2) DEFAULT 0,
  advanced TEXT,
  bet TEXT,
  scaleMode VARCHAR(50),
  slotViewState VARCHAR(50),
  view VARCHAR(255),
  denomination DECIMAL(10,4) DEFAULT 1,
  category_temp VARCHAR(255),
  original_id BIGINT,
  bids TEXT,
  stat_in DECIMAL(15,2) DEFAULT 0,
  stat_out DECIMAL(15,2) DEFAULT 0,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS categories (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255),
  parent BIGINT DEFAULT 0,
  position INT DEFAULT 0,
  href VARCHAR(255),
  original_id BIGINT,
  shop_id BIGINT
);

CREATE TABLE IF NOT EXISTS game_categories (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  game_id BIGINT,
  category_id BIGINT,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS game_log (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT,
  game_id BIGINT,
  shop_id BIGINT,
  bet DECIMAL(15,2) DEFAULT 0,
  win DECIMAL(15,2) DEFAULT 0,
  balance DECIMAL(15,2) DEFAULT 0,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS stat_game (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT,
  game_id BIGINT,
  shop_id BIGINT,
  bet DECIMAL(15,2) DEFAULT 0,
  win DECIMAL(15,2) DEFAULT 0,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS transactions (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT,
  amount DECIMAL(15,2) DEFAULT 0,
  type VARCHAR(50),
  status VARCHAR(50),
  description TEXT,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS payments (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT,
  amount DECIMAL(15,2) DEFAULT 0,
  status VARCHAR(50),
  method VARCHAR(100),
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS payment_settings (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255),
  value TEXT,
  shop_id BIGINT,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS tournaments (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255),
  status TINYINT DEFAULT 1,
  shop_id BIGINT,
  prize_pool DECIMAL(15,2) DEFAULT 0,
  start_at TIMESTAMP NULL,
  end_at TIMESTAMP NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS tournament_games (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  tournament_id BIGINT,
  game_id BIGINT,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS tournament_prizes (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  tournament_id BIGINT,
  place INT,
  amount DECIMAL(15,2) DEFAULT 0,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS tournament_stats (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  tournament_id BIGINT,
  user_id BIGINT,
  points DECIMAL(15,2) DEFAULT 0,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS tournament_categories (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255),
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS tournament_bots (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  tournament_id BIGINT,
  name VARCHAR(255),
  points DECIMAL(15,2) DEFAULT 0,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS bonus_preset (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255),
  amount DECIMAL(15,2) DEFAULT 0,
  shop_id BIGINT,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS welcomebonuses (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT,
  shop_id BIGINT,
  amount DECIMAL(15,2) DEFAULT 0,
  status TINYINT DEFAULT 0,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS sms_bonuses (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255),
  shop_id BIGINT,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS sms_bonus_items (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  bonus_id BIGINT,
  amount DECIMAL(15,2) DEFAULT 0,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS wheelfortune (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT,
  shop_id BIGINT,
  amount DECIMAL(15,2) DEFAULT 0,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS progress (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255),
  shop_id BIGINT,
  target DECIMAL(15,2) DEFAULT 0,
  reward DECIMAL(15,2) DEFAULT 0,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS progress_users (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT,
  progress_id BIGINT,
  current DECIMAL(15,2) DEFAULT 0,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS rewards (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT,
  amount DECIMAL(15,2) DEFAULT 0,
  type VARCHAR(50),
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS notifications (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT,
  message TEXT,
  type VARCHAR(50),
  read_at TIMESTAMP NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS messages (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT,
  message TEXT,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS tickets (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT,
  subject VARCHAR(255),
  status VARCHAR(50) DEFAULT 'open',
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS tickets_answers (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  ticket_id BIGINT,
  user_id BIGINT,
  message TEXT,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS articles (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255),
  content LONGTEXT,
  shop_id BIGINT,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS faqs (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  question TEXT,
  answer TEXT,
  shop_id BIGINT,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS rules (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  content LONGTEXT,
  shop_id BIGINT,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS info (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  content LONGTEXT,
  shop_id BIGINT,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS permissions (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255),
  user_id BIGINT,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS user_activity (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT,
  action VARCHAR(255),
  ip VARCHAR(45),
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS statistics (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT,
  shop_id BIGINT,
  deposit DECIMAL(15,2) DEFAULT 0,
  withdraw DECIMAL(15,2) DEFAULT 0,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS statistics_add (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT,
  shop_id BIGINT,
  amount DECIMAL(15,2) DEFAULT 0,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS credits (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT,
  amount DECIMAL(15,2) DEFAULT 0,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS withdraw_funds (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT,
  amount DECIMAL(15,2) DEFAULT 0,
  status VARCHAR(50),
  method VARCHAR(100),
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS deposit_limits (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT,
  amount DECIMAL(15,2) DEFAULT 0,
  period VARCHAR(50),
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS self_exclusions (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT,
  until TIMESTAMP NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS securities (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT,
  type VARCHAR(50),
  value VARCHAR(255),
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS pincodes (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT,
  pincode VARCHAR(10),
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS invites (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT,
  code VARCHAR(50),
  used TINYINT DEFAULT 0,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS happyhours (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255),
  shop_id BIGINT,
  multiplier DECIMAL(5,2) DEFAULT 1,
  start_time TIME,
  end_time TIME,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS subsessions (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT,
  shop_id BIGINT,
  token VARCHAR(255),
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS open_shift (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT,
  shop_id BIGINT,
  balance_open DECIMAL(15,2) DEFAULT 0,
  balance_close DECIMAL(15,2) DEFAULT 0,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS open_shift_temp (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT,
  shop_id BIGINT,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS quick_shops (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255),
  shop_id BIGINT,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS shop_categories (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255),
  shop_id BIGINT,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS shops_countries (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  shop_id BIGINT,
  country VARCHAR(10),
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS shops_devices (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  shop_id BIGINT,
  device VARCHAR(50),
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS shops_os (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  shop_id BIGINT,
  os VARCHAR(50),
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS shops_user (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  shop_id BIGINT,
  user_id BIGINT,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS api_tokens (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  token VARCHAR(255),
  shop_id BIGINT,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS apis (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255),
  url VARCHAR(255),
  shop_id BIGINT,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS bots_games (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  game_id BIGINT,
  shop_id BIGINT,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS fish_bank (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  game_id BIGINT,
  amount DECIMAL(15,2) DEFAULT 0,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS game_bank (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  game_id BIGINT,
  amount DECIMAL(15,2) DEFAULT 0,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS jpg (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255),
  path VARCHAR(500),
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS sms (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT,
  phone VARCHAR(50),
  message TEXT,
  status VARCHAR(50),
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS sms_mailings (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255),
  shop_id BIGINT,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS sms_mailing_messages (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  mailing_id BIGINT,
  message TEXT,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

CREATE TABLE IF NOT EXISTS tasks (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255),
  status VARCHAR(50),
  shop_id BIGINT,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);

-- Insert default shop
INSERT IGNORE INTO shops (id, name, currency, status) VALUES (1, 'ApexBet', 'USD', 1);

-- Insert default settings
INSERT IGNORE INTO w_settings (key_name, value) VALUES
('installed', '1'),
('site_name', 'ApexBet'),
('site_status', '1'),
('version', '1.0');
