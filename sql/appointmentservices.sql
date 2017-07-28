CREATE TABLE 'wp_appointments' 
('id' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 'name' VARCHAR NOT NULL, 
'appointment_date' DATETIME NOT NULL, 'phone' VARCHAR NOT NULL);
CREATE TABLE 'wp_appointment_services' 
('id' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, 
'service_name' VARCHAR NOT NULL, 
'wp_appointments_id_fk' INTEGER NOT NULL);