create table if not exists  Producto_hardware(
    id integer primary key autoincrement,
    nombre varchar(50),
    categoria varchar(20),
    precio varchar(10),
    cantidad_en_stock varchar(20),
    proveedor varchar(30),
);
insert into Producto_hardware (nombre, categoria, precio, cantidad_en_stock, proveedor) values('procesador','ryzen', '4000', '100'. 'amd');
insert into Producto_hardware (nombre, categoria, precio, cantidad_en_stock, proveedor) values('ram','ddr4', '500', '150'. 'adata');
insert into Producto_hardware (nombre, categoria, precio, cantidad_en_stock, proveedor) values('ssd','m.2', '1000', '250'. 'acer');
