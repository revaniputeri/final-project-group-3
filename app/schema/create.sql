CREATE TABLE [dbo].[User] (
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

CREATE TABLE [dbo].[Student] (
    [Id]                 INT          NOT NULL IDENTITY (1, 1),
    [UserId]             INT          NOT NULL,
    [StudentMajor]       VARCHAR(255) NOT NULL,
    [StudentStatus]      INT          NOT NULL,
    CONSTRAINT [PK_Student] PRIMARY KEY ([Id])
);

CREATE TABLE [dbo].[Lecturer] (
    [Id]                 INT          NOT NULL IDENTITY (1, 1),
    [UserId]             INT          NOT NULL,
    [ExpertiseField]     VARCHAR(255) NOT NULL, -- EX: Computer Science, Mathematics, etc.
    [Major]              VARCHAR(255) NOT NULL,
    CONSTRAINT [PK_Lecturer] PRIMARY KEY ([Id])
);

CREATE TABLE [dbo].[Achievement] (
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
    [CompetitionRank]            VARCHAR(50)  NOT NULL, -- 1st, 2nd, 3rd, etc.
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
    [Points]                     FLOAT        NOT NULL, -- SUM of [CompetitionLevel] and [CompetitionRank]
    [SupervisorId]               INT          NULL,     -- NULL if no supervisor needed
    [SupervisorValidationStatus] VARCHAR(20)  NULL,     -- NULL/PENDING/APPROVED/REJECTED
    [SupervisorValidationDate]   DATETIME     NULL,     -- When supervisor validated
    [SupervisorValidationNote]   TEXT         NULL,     -- Supervisor feedback/notes
    [AdminValidationStatus]      VARCHAR(20)  NOT NULL DEFAULT 'PENDING',
    [AdminValidationDate]        DATETIME     NULL,     -- When admin validated
    [AdminValidationNote]        TEXT         NULL,     -- Admin feedback/notes
    [CreatedAt]                  DATETIME     NOT NULL DEFAULT GETDATE(),
    [UpdatedAt]                  DATETIME     NOT NULL DEFAULT GETDATE(),
    [DeletedAt]                  DATETIME     NULL,
    CONSTRAINT [PK_Achievement] PRIMARY KEY ([Id])
);

CREATE TABLE [dbo].[UserAchievement] (
    [Id]                         INT          NOT NULL IDENTITY (1, 1),
    [UserId]                     INT          NULL,
    [AchievementId]              INT          NULL,
    [AchievementRole]            VARCHAR(255) NULL,
    CONSTRAINT [PK_UserAchievement] PRIMARY KEY ([id])
);

ALTER TABLE [dbo].[Student]
    ADD CONSTRAINT [FK_Student] 
        FOREIGN KEY ([UserId]) REFERENCES [dbo].[User] ([Id]) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE [dbo].[Lecturer]
    ADD CONSTRAINT [FK_Lecturer] 
        FOREIGN KEY ([UserId]) REFERENCES [dbo].[User] ([Id]) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE [dbo].[Achievement]
    ADD CONSTRAINT [FK_Achievement]
        FOREIGN KEY ([UserId]) REFERENCES [dbo].[User] ([Id]) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE [dbo].[UserAchievement]
    ADD CONSTRAINT [FK_UserAchievement_User]
        FOREIGN KEY ([UserId]) REFERENCES [dbo].[User] ([Id]) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE [dbo].[UserAchievement]
    ADD CONSTRAINT [FK_UserAchievement_Achievement]
        FOREIGN KEY ([AchievementId]) REFERENCES [dbo].[Achievement] ([Id]) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE [dbo].[Achievement]
    ADD CONSTRAINT [FK_Achievement_Supervisor]
        FOREIGN KEY ([SupervisorId]) REFERENCES [dbo].[Lecturer] ([Id]);
