CREATE TABLE Devices (
    DeviceID INT PRIMARY KEY AUTO_INCREMENT,
    DeviceName VARCHAR(100),
    Description TEXT,
    Status VARCHAR(20) -- Status of the device (e.g., 'Active', 'Inactive')
);
