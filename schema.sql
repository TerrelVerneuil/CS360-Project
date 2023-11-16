CREATE TABLE shop_user(
    userID INT AUTO_INCREMENT,
    name VARCHAR(32),
    isAdmin BOOLEAN,
    created_at DATETIME,
    PRIMARY KEY(userID)
);

CREATE TABLE buyer(
    buyerID INT,
    FOREIGN KEY(buyerID) REFERENCES shop_user(userID),
    PRIMARY KEY(buyerID)
);

CREATE TABLE seller(
    sellerID INT,
    FOREIGN KEY(sellerID) REFERENCES shop_user(userID),
    PRIMARY KEY(sellerID)
);

CREATE TABLE wishlist(
    wishlistID INT AUTO_INCREMENT,
    buyerID INT,
    FOREIGN KEY(buyerID) REFERENCES buyer(buyerID),
    PRIMARY KEY(wishlistID)
);

CREATE TABLE item(
    itemID INT AUTO_INCREMENT,
    sid INT,
    wid INT,
    name VARCHAR(128),
    price DECIMAL,
    description VARCHAR(256),
    itemPicture VARCHAR(256),
    itemCat VARCHAR(64),
    FOREIGN KEY(sid) REFERENCES seller(sellerID),
    FOREIGN KEY(wid) REFERENCES wishlist(wishlistID),
    PRIMARY KEY(itemID)
);

CREATE TABLE reviews(
    reviewID INT AUTO_INCREMENT,
    rating INT,
    message VARCHAR(256),
    subject VARCHAR(64),
    reviewerID INT,
    sellerID INT,
    FOREIGN KEY(reviewerID) REFERENCES shop_user(userID),
    FOREIGN KEY(sellerID) REFERENCES seller(sellerID),
    PRIMARY KEY(reviewID)
);

CREATE TABLE cart(
    cartID INT AUTO_INCREMENT,
    bid INT,
    FOREIGN KEY(bid) REFERENCES buyer(buyerID),
    PRIMARY KEY(cartID)
);

CREATE TABLE cart_order(
    orderID INT AUTO_INCREMENT,
    cid integer,
    date DATETIME,
    FOREIGN KEY(cid) REFERENCES cart(cartID),
    PRIMARY KEY(orderID)
);

CREATE TABLE contains(
    itemID INT,
    cartID INT,
    FOREIGN KEY(itemID) REFERENCES item(itemID),
    FOREIGN KEY(cartID) REFERENCES cart(cartID)
);