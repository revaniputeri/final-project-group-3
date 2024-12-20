-- Drop foreign key constraints first
IF EXISTS (SELECT * FROM sys.foreign_keys WHERE name = 'FK_UserAchievement_Achievement')
    ALTER TABLE [dbo].[UserAchievement] DROP CONSTRAINT [FK_UserAchievement_Achievement];

IF EXISTS (SELECT * FROM sys.foreign_keys WHERE name = 'FK_UserAchievement_User')
    ALTER TABLE [dbo].[UserAchievement] DROP CONSTRAINT [FK_UserAchievement_User];

IF EXISTS (SELECT * FROM sys.foreign_keys WHERE name = 'FK_Achievement_User')
    ALTER TABLE [dbo].[Achievement] DROP CONSTRAINT [FK_Achievement_User];

IF EXISTS (SELECT * FROM sys.foreign_keys WHERE name = 'FK_Lecturer_User')
    ALTER TABLE [dbo].[Lecturer] DROP CONSTRAINT [FK_Lecturer_User];

IF EXISTS (SELECT * FROM sys.foreign_keys WHERE name = 'FK_Student_User')
    ALTER TABLE [dbo].[Student] DROP CONSTRAINT [FK_Student_User];

-- Drop tables
IF EXISTS (SELECT * FROM sys.tables WHERE name = 'UserAchievement')
    DROP TABLE [dbo].[UserAchievement];

IF EXISTS (SELECT * FROM sys.tables WHERE name = 'Achievement')
    DROP TABLE [dbo].[Achievement];

IF EXISTS (SELECT * FROM sys.tables WHERE name = 'Lecturer')
    DROP TABLE [dbo].[Lecturer];

IF EXISTS (SELECT * FROM sys.tables WHERE name = 'Student')
    DROP TABLE [dbo].[Student];

IF EXISTS (SELECT * FROM sys.tables WHERE name = 'User')
    DROP TABLE [dbo].[User];

-- Delete data from UserAchievement
-- IF EXISTS (SELECT * FROM sys.tables WHERE name = 'UserAchievement')
--     DELETE FROM [dbo].[UserAchievement];

-- -- Delete data from Achievement
-- IF EXISTS (SELECT * FROM sys.tables WHERE name = 'Achievement')
--     DELETE FROM [dbo].[Achievement];



