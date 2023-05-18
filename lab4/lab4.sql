CREATE TABLE car (
  car_id INT AUTO_INCREMENT PRIMARY KEY,
  make VARCHAR(255),
  model VARCHAR(255),
  price INT,
  yom INT
);


INSERT INTO car (make, model, price, yom) VALUES
  ('Holden', 'Astra', 14000, 2005),
  ('BMW', 'G71', 35000, 2021),
  ('Ford', 'Falcon', 39000, 2010),
  ('Toyota', 'Corolla', 20000, 2018),
  ('Holden', 'Commodore', 13500, 2005),
  ('Holden', 'Astra', 8000, 2001),
  ('Holden', 'Commodore', 28000, 2009),
  ('Ford', 'Falcon', 14000, 2019),
  ('Ford', 'Falcon', 7000, 2003),
  ('Ford', 'Laser', 10000, 2001),
  ('Mazda', 'RX-7', 26000, 2000),
  ('Toyota', 'Corolla', 12000, 2020),
  ('Mazda', '3', 14500, 2007);


SELECT * FROM car;


SELECT make, model, price FROM car
ORDER BY make, model;


SELECT make, model FROM car
WHERE price >= 20000;


SELECT make, model FROM car
WHERE price < 15000;


SELECT make, model, AVG(price) AS average_price
FROM car
GROUP BY make, model;

