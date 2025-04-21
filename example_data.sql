-- Example data for S-RECCER community section
-- This file contains sample data for posts, comments, and users

-- Create users first
INSERT INTO user (userID, userName, userPic, userEmail, userPassword) VALUES
('U1', 'toetickler', 'images/profile3.jpeg', 'toetickler@example.com', 'hashedpassword123'),
('U2', 'gayhater', 'images/profile2.jpeg', 'gayhater@example.com', 'hashedpassword123'),
('U3', 'jazzLover', 'images/profile5.jpeg', 'jazzlover@example.com', 'hashedpassword123'),
('U4', 'musicnerd', 'images/profile4.jpeg', 'musicnerd@example.com', 'hashedpassword123');

-- Create posts
INSERT INTO post (postID, postTitle, postContent, postDateTime, USER_userID) VALUES
('P1', 'LISA ALTEREGO ALBUM RATING', 'Absolutely loved her new album! A few skips... but overall still great!\n1. Born Again: 10/10\n2. ROCKSTAR: 7/10\n3. Elastigirl: 6/10\n4. Moonlit Floor: 8/10\n5. Lifestyle: 10/10!!', '2024-03-15 14:30:00', 'U1'),
('P2', 'Anyone Selling Wave to Earth Vinyls?', 'IM BEGGING... please anybody... let me buy your wave to earth vinyl... im desperate', '2024-03-15 15:45:00', 'U2'),
('P3', 'Just discovered Joji!', 'Why did nobody tell me about Joji sooner? Glimpse of Us has been on repeat all week. Any recommendations for similar songs?', '2024-03-16 09:15:00', 'U3'),
('P4', 'Beabadoobee Concert Experience', 'Just got back from seeing Beabadoobee live and WOW! The energy was incredible. She played all my favorites from Beatopia. Anyone else catch her on this tour?', '2024-03-16 20:30:00', 'U4');

-- Create comments
INSERT INTO comment (commentID, commentContent, commentDateTime, USER_userID, POST_postID) VALUES
('C1', 'Totally agree about Lifestyle! Its definitely the standout track', '2024-03-15 14:45:00', 'U4', 'P1'),
('C2', 'I saw some on Discogs last week, might want to check there!', '2024-03-15 16:00:00', 'U3', 'P2'),
('C3', 'Try listening to Slow Dancing in the Dark next!', '2024-03-16 09:30:00', 'U1', 'P3'),
('C4', 'NECTAR album is a masterpiece', '2024-03-16 09:45:00', 'U2', 'P3'),
('C5', 'The See You Soon performance was incredible!', '2024-03-16 21:00:00', 'U1', 'P4'); 