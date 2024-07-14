DROP DATABASE IF EXISTS mysqli_wrapper_test;
DROP USER IF EXISTS mysqli_wrapper_test_all@127.0.0.1;
DROP USER IF EXISTS mysqli_wrapper_test_only_insert@127.0.0.1;
DROP USER IF EXISTS mysqli_wrapper_test_only_select@127.0.0.1;

CREATE DATABASE mysqli_wrapper_test;
USE mysqli_wrapper_test;

CREATE TABLE `test` (
  `a` VARCHAR(8) NOT NULL,
  `b` INTEGER UNSIGNED NOT NULL,
  `c` FLOAT UNSIGNED NOT NULL
) ENGINE=InnoDB;

CREATE USER mysqli_wrapper_test_all@127.0.0.1 IDENTIFIED BY 'mysqli_wrapper_test_all_password';
GRANT ALL PRIVILEGES ON mysqli_wrapper_test.* TO mysqli_wrapper_test_all@127.0.0.1;

CREATE USER mysqli_wrapper_test_only_insert@127.0.0.1 IDENTIFIED BY 'mysqli_wrapper_test_only_insert_password';
GRANT INSERT ON mysqli_wrapper_test.test TO mysqli_wrapper_test_only_insert@127.0.0.1;

CREATE USER mysqli_wrapper_test_only_select@127.0.0.1 IDENTIFIED BY 'mysqli_wrapper_test_only_select_password';
GRANT SELECT ON mysqli_wrapper_test.test TO mysqli_wrapper_test_only_select@127.0.0.1;
