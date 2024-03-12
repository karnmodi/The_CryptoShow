CREATE TABLE LoginHistory (
    LoginHistoryID INT PRIMARY KEY AUTO_INCREMENT,
    LoginDate DATE,
    MemberID INT,
    FOREIGN KEY (MemberID) REFERENCES Member(MemberID)
);