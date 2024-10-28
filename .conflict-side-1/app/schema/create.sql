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
    [Name]               VARCHAR(255) NOT NULL,
    [Email]              VARCHAR(255) NOT NULL,
    [Username]           VARCHAR(255) NOT NULL, --NIP, NIM, NIPD
    [CreatedAt]          DATETIME     NOT NULL DEFAULT GETDATE(),
    [UpdatedAt]          DATETIME     NOT NULL DEFAULT GETDATE(),
    [DeletedAt]          DATETIME     NULL,
    CONSTRAINT [PK_Mahasiswa] PRIMARY KEY ([Id]),
    CONSTRAINT [FK_Mahasiswa_User] FOREIGN KEY ([UserId]) REFERENCES [dbo].[User] ([Id])
);

CREATE TABLE
    [dbo].[Lecturer]
(
    [Id]                 INT          NOT NULL IDENTITY (1, 1),
    [UserId]             INT          NOT NULL,
    [Name]               VARCHAR(255) NOT NULL,
    [Email]              VARCHAR(255) NOT NULL,
    [Username]           VARCHAR(255) NOT NULL, --NIP, NIM, NIPD
    [CreatedAt]          DATETIME     NOT NULL DEFAULT GETDATE(),
    [UpdatedAt]          DATETIME     NOT NULL DEFAULT GETDATE(),
    [DeletedAt]          DATETIME     NULL,
    CONSTRAINT [PK_Lecturer] PRIMARY KEY ([Id]),
    CONSTRAINT [FK_Lecturer_User] FOREIGN KEY ([UserId]) REFERENCES [dbo].[User] ([Id])
);

