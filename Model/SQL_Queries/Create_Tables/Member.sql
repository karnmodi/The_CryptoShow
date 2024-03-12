CREATE TABLE Member (
    MemberID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(50),
    Email VARCHAR(100),
    Password VARCHAR(20),
    UserType VARCHAR(20) -- This can be either 'Organizer' or 'Admin'
);