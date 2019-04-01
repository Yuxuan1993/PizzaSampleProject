-- Portable script for creating the pizza database
-- on your dev system:
-- mysql -u root -p < dev_setup.sql    
-- mysql -D pizzadb -u root -p < createdb.sql 
--  or, on topcat:
-- mysql -D <user>db -u <user> -p < createdb.sql 
create table sizes(
id integer auto_increment,
size_name varchar(30) not null,
unique (size_name),
primary key(id)
);

create table toppings(
id integer auto_increment,
topping_name varchar(30) not null,
unique (topping_name),
primary key(id)
);

create table status_values (
status_value varchar(10) primary key
);

create table pizza_orders(
id integer auto_increment,
room_number integer not null,
size varchar(30) not null,
day integer not null,
status varchar(10) references status_values(status_value),
primary key(id)
);

-- toppings for a pizza order
-- Note: we can't use a foreign key to toppings here because the topping
-- might be deleted while the order is still in the system
create table order_topping (
order_id integer not null,
topping varchar(30) not null,
primary key (order_id, topping),
foreign key (order_id) references pizza_orders(id));

-- one-row table doesn't need a primary key
create table pizza_sys_tab (
current_day integer not null
);


insert into pizza_sys_tab values (1);
-- minimal toppings and sizes: one each
insert into toppings values (1,'Pepperoni');
insert into sizes values (1,'small');
insert into status_values values ('Preparing');
insert into status_values values ('Baked');
insert into status_values values ('Finished');

-- Assume each ingredient only use 1 unit per pizza
-- Assume maximum orders per day is 50 orders
-- Each ingredient can store maximum 250 units
-- Minimum qty for each ingredient is 150 units (3 days supplies)
create table inventory (
product_id integer not null,
product varchar(30) not null,
quantity integer not null,
unit_qty integer not null, -- minimum qty to order per bag/container
primary key (product_id)
);

create table undeliveried_orders (
orderid integer auto_increment,
flour_qty integer not null,
cheese_qty integer not null,
primary key (orderid)
);

insert into inventory value (11, 'flour', 100, 40);
insert into inventory value (12, 'cheese', 100, 20);