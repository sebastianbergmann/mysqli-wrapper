DROP DATABASE IF EXISTS mysqli_wrapper_test;
DROP USER IF EXISTS mysqli_wrapper_test_all_privileges@localhost;
DROP USER IF EXISTS mysqli_wrapper_test_only_insert_privilege@localhost;
DROP USER IF EXISTS mysqli_wrapper_test_only_select_privilege@localhost;

CREATE DATABASE mysqli_wrapper_test;
USE mysqli_wrapper_test;

CREATE TABLE `test` (
  `id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,

  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE USER mysqli_wrapper_test_all_privileges@localhost IDENTIFIED BY 'mysqli_wrapper_test_all_privileges_password';
GRANT ALL PRIVILEGES ON mysqli_wrapper_test.* TO mysqli_wrapper_test_all_privileges@localhost;

CREATE USER mysqli_wrapper_test_only_insert_privilege@localhost IDENTIFIED BY 'mysqli_wrapper_test_only_insert_privilege_password';
GRANT INSERT ON mysqli_wrapper_test.test TO mysqli_wrapper_test_only_insert_privilege@localhost;

CREATE USER mysqli_wrapper_test_only_select_privilege@localhost IDENTIFIED BY 'mysqli_wrapper_test_only_select_privilege_password';
GRANT SELECT ON mysqli_wrapper_test.test TO mysqli_wrapper_test_only_select_privilege@localhost;
