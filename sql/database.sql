---------- Delete  tables ----------

DROP TABLE series;
DROP TABLE product;
DROP TABLE productSize;


--------- Create tables ----------

CREATE TABLE series(
    seriesID VARCHAR(3) PRIMARY KEY NOT NULL,
    seriesName VARCHAR(15)
);

-- Example: Yonex A60, Adidas B60
CREATE TABLE product(
    productID VARCHAR(5) PRIMARY KEY NOT NULL,
    productName VARCHAR(100) NOT NULL,
    price FLOAT(6,2) NOT NULL,
    seriesID VARCHAR(3),
    FOREIGN KEY(seriesID) REFERENCES series(seriesID)
);

-- Example: Yonex A60 (3UG5), Yonex A60 (4UG5), Adidas B60 (3UG5), Adidas B60 (4UG5)
CREATE TABLE productSize(
    productID VARCHAR(5) NOT NULL,
    sizeID VARCHAR(4) NOT NULL,
    quantity INT NOT NULL,
    PRIMARY KEY (productID, sizeID),
    FOREIGN KEY (productID) REFERENCES product(productID)
);
    

--------- Insert records ----------

INSERT INTO series values ("AST", "Astrox");
INSERT INTO series values ("NAN", "Nanoflare");
INSERT INTO series values ("ARC", "Arcsaber");

INSERT INTO product values ("R0001", "Yonex Arcsaber 11 Pro", 849.00,"ARC");
INSERT INTO product values ("R0002", "Yonex Nanoflare 1000z", 799.00,"NAN");
INSERT INTO product values ("R0001", "Yonex Astrox 88D Pro", 899.00,"AST");

INSERT INTO productSize values ("R0001","4UG5",5);
INSERT INTO productSize values ("R0001","3UG5",4);
INSERT INTO productSize values ("R0002","4UG5",6);
INSERT INTO productSize values ("R0002","3UG5",5);
INSERT INTO productSize values ("R0003","4UG5",3);
INSERT INTO productSize values ("R0003","3UG5",2);