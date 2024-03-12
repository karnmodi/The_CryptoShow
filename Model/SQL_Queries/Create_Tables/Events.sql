CREATE TABLE Events (
    EventID INT PRIMARY KEY AUTO_INCREMENT,
    OrganizerID INT, -- Member ID of the organizer
    DeviceID INT, -- Device ID of the device used in the event
    EventDate DATE,
    EventTime TIME,
    FOREIGN KEY (OrganizerID) REFERENCES Member(MemberID),
    FOREIGN KEY (DeviceID) REFERENCES Devices(DeviceID)
);