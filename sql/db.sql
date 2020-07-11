CREATE TABLE IF NOT EXISTS user_details(
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(255),
	password VARCHAR(255),
	email VARCHAR(255),
	full_name VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS product(
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(255),
	image VARCHAR(255),
	price DECIMAL(10,0)
);

CREATE TABLE IF NOT EXISTS product_category(
	category VARCHAR(255),
	product_id INT(6) UNSIGNED,
	FOREIGN KEY (product_id) REFERENCES product(id)
);

CREATE TABLE IF NOT EXISTS order_number(
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	user_id INT(6) UNSIGNED,
	FOREIGN KEY (user_id) REFERENCES user_details(id)
);

CREATE TABLE IF NOT EXISTS order_details(
	qty INT,
	order_id INT(6) UNSIGNED,
	FOREIGN KEY (order_id) REFERENCES order_number(id),
	product_id INT(6) UNSIGNED,
	FOREIGN KEY (product_id) REFERENCES product(id)
);
CREATE TABLE IF NOT EXISTS user_address(
	address VARCHAR(255),
	payment VARCHAR(255),
	user_id INT(6) UNSIGNED,
	FOREIGN KEY (user_id) REFERENCES user_details(id)
);