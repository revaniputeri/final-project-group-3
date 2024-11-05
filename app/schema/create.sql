CREATE TABLE
    [dbo].[User]
(
    [Id]                 INT          NOT NULL IDENTITY (1, 1),
    [FullName]           VARCHAR(255) NOT NULL,
    [Username]           VARCHAR(255) NOT NULL, --NIP, NIM, NIPD
    [Password]           VARCHAR(255) NOT NULL,
    [Email]              VARCHAR(255) NOT NULL,
    [Phone]              VARCHAR(255) NOT NULL,
    [Avatar]             VARCHAR(255) NOT NULL,
    [Role]               VARCHAR(8)   NOT NULL, -- ADMIN, STUDENT, LECTURER
    [CreatedAt]          DATETIME     NOT NULL DEFAULT GETDATE(),
    [UpdatedAt]          DATETIME     NOT NULL DEFAULT GETDATE(),
    [DeletedAt]          DATETIME     NULL,
    CONSTRAINT [PK_User] PRIMARY KEY ([Id])
);

CREATE TABLE
    [dbo].[Student]
(
    [Id]                 INT          NOT NULL IDENTITY (1, 1),
    [UserId]             INT          NOT NULL,
    [StudentMajor]       VARCHAR(255) NOT NULL,
    [StudentStatus]      INT          NOT NULL,
    CONSTRAINT [PK_Student] PRIMARY KEY ([Id])
);

CREATE TABLE 
    [dbo].[Achievement]
(
    [Id]                         INT          NOT NULL IDENTITY (1, 1),
    [UserId]                     INT          NOT NULL,
    [CompetitionType]            VARCHAR(50)  NOT NULL,
    [CompetitionLevel]           VARCHAR(50)  NOT NULL,
    [CompetitionPoints]          FLOAT        NOT NULL,
    [CompetitionTitle]           VARCHAR(255) NOT NULL,
    [CompetitionTitleEnglish]    VARCHAR(255) NOT NULL,
    [CompetitionPlace]           VARCHAR(255) NOT NULL,
    [CompetitionPlaceEnglish]    VARCHAR(255) NOT NULL,
    [CompetitionUrl]             VARCHAR(255) NOT NULL,
    [CompetitionStartDate]       DATETIME     NOT NULL,
    [CompetitionEndDate]         DATETIME     NOT NULL,
    -- number of institutions mean number of institution that participated in the competition
    [NumberOfInstitutions]       INT          NOT NULL,
    [NumberOfStudents]           INT          NOT NULL,
    [LetterNumber]               VARCHAR(50)  NOT NULL,
    [LetterDate]                 DATETIME     NOT NULL,
    -- upload required file
    [LetterFile]                 VARCHAR(255) NOT NULL,
    [CertificateFile]            VARCHAR(255) NOT NULL,
    [DocumentationFile]          VARCHAR(255) NOT NULL,
    [PosterFile]                 VARCHAR(255) NOT NULL,
    [CreatedAt]                  DATETIME     NOT NULL DEFAULT GETDATE(),
    [UpdatedAt]                  DATETIME     NOT NULL DEFAULT GETDATE(),
    [DeletedAt]                  DATETIME     NOT NULL DEFAULT GETDATE(),
    CONSTRAINT [PK_Achievement] PRIMARY KEY ([id])
);

CREATE TABLE 
    [dbo].[UserAchievement] 
(
    [Id]                         INT          NOT NULL IDENTITY (1, 1),
    [UserId]                     INT          NOT NULL,
    [AchievementId]              INT          NOT NULL,
    [AchievementRole]            VARCHAR(255) NOT NULL,
    CONSTRAINT [PK_UserAchievement] PRIMARY KEY ([id])
);

ALTER TABLE
    [dbo].[Student]
    ADD CONSTRAINT [FK_Student] 
        FOREIGN KEY ([UserId]) REFERENCES [dbo].[User] ([Id]) ON DELETE CASCADE on UPDATE CASCADE;

ALTER TABLE
    [dbo].[Achievement]
    ADD CONSTRAINT [FK_Achievement]
        FOREIGN KEY ([UserId]) REFERENCES [dbo].[User] ([Id]) ON DELETE CASCADE on UPDATE CASCADE;

ALTER TABLE
    [dbo].[UserAchievement]
    ADD CONSTRAINT [FK_UserAchievement_User]
        FOREIGN KEY ([UserId]) REFERENCES [dbo].[User] ([Id]) ON DELETE CASCADE on UPDATE CASCADE;

ALTER TABLE
    [dbo].[UserAchievement]
    ADD CONSTRAINT [FK_UserAchievement_Achievement]
        FOREIGN KEY ([AchievementId]) REFERENCES [dbo].[Achievement] ([Id]) ON DELETE CASCADE on UPDATE CASCADE;

