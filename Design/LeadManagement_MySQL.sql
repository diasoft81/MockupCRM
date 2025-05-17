
CREATE TABLE companies (
  Id CHAR(36) NOT NULL,
  CompanyShortName VARCHAR(10),
  CompanyName VARCHAR(200),
  CompanyEmail VARCHAR(200),
  CompanyAddress VARCHAR(200),
  CompanyRegion VARCHAR(50),
  CompanyCity VARCHAR(50),
  CompanyLatitude DECIMAL(19,4),
  CompanyLongitude DECIMAL(19,4),
  CompanyPhone VARCHAR(50),
  CompanyTaxId VARCHAR(50),
  CompanyBank VARCHAR(50),
  CompanyBankAcc VARCHAR(50),
  ConsumerSegment VARCHAR(100),
  CustomerCategory VARCHAR(100),
  AdditionalNotes TEXT,
  Status VARCHAR(100),
  LastBy CHAR(36),
  LastDate DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (Id)
);

CREATE TABLE contact_persons (
  Id CHAR(36) NOT NULL,
  Name VARCHAR(200),
  Email VARCHAR(200),
  Phone VARCHAR(50),
  Mobile VARCHAR(50),
  Address VARCHAR(200),
  Region VARCHAR(50),
  City VARCHAR(50),
  Latitude DECIMAL(19,4),
  Longitude DECIMAL(19,4),
  Status VARCHAR(100),
  LastBy CHAR(36),
  LastDate DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (Id)
);

CREATE TABLE products (
  Id CHAR(36) NOT NULL DEFAULT (UUID()),
  Type VARCHAR(100) NOT NULL,
  Merk VARCHAR(100) NOT NULL,
  Model VARCHAR(100) NOT NULL,
  Description TEXT,
  Quantity INT NOT NULL DEFAULT 0,
  CostPrice DECIMAL(19,4),
  LowerBound DECIMAL(19,4),
  UpperBound DECIMAL(19,4),
  DiscountedPrice DECIMAL(19,4),
  LastBy CHAR(36),
  LastDate DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (Id)
);

CREATE TABLE leads (
  Id CHAR(36) NOT NULL,
  CompanyId CHAR(36),
  ContactId CHAR(36),
  LeadName VARCHAR(100),
  LeadStatus VARCHAR(100),
  LeadSource VARCHAR(100),
  CurrentStage VARCHAR(100),
  ExpectedCloseDate DATETIME,
  CloseDate DATETIME,
  Amount DECIMAL(19,4),
  Status VARCHAR(100),
  LastBy CHAR(36),
  LastDate DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (Id)
);

CREATE TABLE lead_products (
  Id CHAR(36) NOT NULL,
  LeadId CHAR(36),
  ProductId CHAR(36),
  Quantity INT,
  UnitPrice DECIMAL(19,4),
  TotalPrice DECIMAL(19,4),
  Status VARCHAR(100),
  LastBy CHAR(36),
  LastDate DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (Id)
);


