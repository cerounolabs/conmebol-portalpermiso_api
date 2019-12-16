CREATE SCHEMA [adm]
GO

CREATE TABLE [adm].[DOMPAR](
	[DOMPARCOD] [int] IDENTITY(1,1) NOT NULL,
	[DOMPAREST] [char](1) NOT NULL,
	[DOMPARTST] [char](1) NOT NULL,
	[DOMPARORD] [int] NULL,
	[DOMPARPC1] [int] NOT NULL,
	[DOMPARPC2] [int] NOT NULL,
	[DOMPARPC3] [char](10) NOT NULL,
	[DOMPARDIC] [int] NULL,
	[DOMPARDIO] [char](1) NULL,
	[DOMPARDIU] [char](1) NULL,
	[DOMPARADJ] [char](1) NULL,
	[DOMPAROBS] [varchar](5120) NULL,
	[DOMPARAUS] [char](20) NOT NULL,
	[DOMPARAFH] [datetime] NOT NULL,
	[DOMPARAIP] [char](20) NOT NULL,
 CONSTRAINT [PK_DOMPARCOD] PRIMARY KEY CLUSTERED ([DOMPARCOD] ASC) WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]) ON [PRIMARY]
GO

CREATE TABLE [adm].[DOMPARA](
	[DOMPARAIDD] [int] IDENTITY(1,1) NOT NULL,
	[DOMPARAMET] [char](20) NOT NULL,
	[DOMPARAUSU] [char](20) NOT NULL,
	[DOMPARAFEC] [datetime] NOT NULL,
	[DOMPARADIP] [char](20) NOT NULL,
	[DOMPARACOD] [int] NULL,
	[DOMPARAEST] [char](1) NULL,
	[DOMPARATST] [char](1) NULL,
	[DOMPARAORD] [int] NULL,
	[DOMPARAPC1] [int] NULL,
	[DOMPARAPC2] [int] NULL,
	[DOMPARAPC3] [char](10) NULL,
	[DOMPARADIC] [int] NULL,
	[DOMPARADIO] [char](1) NULL,
	[DOMPARADIU] [char](1) NULL,
	[DOMPARAADJ] [char](1) NULL,
	[DOMPARAOBS] [varchar](5120) NULL,
 CONSTRAINT [PK_DOMPARAIDD] PRIMARY KEY CLUSTERED ([DOMPARAIDD] ASC) WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]) ON [PRIMARY]
GO

CREATE TRIGGER [adm].[DOMPAR_INSERT] 
	ON [adm].[DOMPAR]
	AFTER INSERT
	AS
	BEGIN
		SET NOCOUNT ON;
		INSERT INTO [adm].[DOMPARA] (DOMPARAMET, DOMPARAUSU, DOMPARAFEC, DOMPARADIP, DOMPARACOD, DOMPARAEST, DOMPARATST, DOMPARAORD, DOMPARAPC1, DOMPARAPC2, DOMPARAPC3, DOMPARADIC, DOMPARADIO, DOMPARADIU, DOMPARAADJ, DOMPARAOBS)
		SELECT 'INSERT AFTER', i.DOMPARAUS, GETDATE(), i.DOMPARAIP, i.DOMPARCOD, i.DOMPAREST, i.DOMPARTST, i.DOMPARORD, i.DOMPARPC1, i.DOMPARPC2, i.DOMPARPC3, i.DOMPARDIC, i.DOMPARDIO, i.DOMPARDIU, i.DOMPARADJ, i.DOMPAROBS FROM INSERTED i;
	END
GO

CREATE TRIGGER [adm].[DOMPAR_UPDATE] 
	ON [adm].[DOMPAR]
	AFTER UPDATE
	AS
	BEGIN
		SET NOCOUNT ON;
		INSERT INTO [adm].[DOMPARA] (DOMPARAMET, DOMPARAUSU, DOMPARAFEC, DOMPARADIP, DOMPARACOD, DOMPARAEST, DOMPARATST, DOMPARAORD, DOMPARAPC1, DOMPARAPC2, DOMPARAPC3, DOMPARADIC, DOMPARADIO, DOMPARADIU, DOMPARAADJ, DOMPARAOBS)
		SELECT 'UPDATE BEFORE', d.DOMPARAUS, GETDATE(), d.DOMPARAIP, d.DOMPARCOD, d.DOMPAREST, d.DOMPARTST, d.DOMPARORD, d.DOMPARPC1, d.DOMPARPC2, d.DOMPARPC3, d.DOMPARDIC, d.DOMPARDIO, d.DOMPARDIU, d.DOMPARADJ, d.DOMPAROBS FROM DELETED d;

		INSERT INTO [adm].[DOMPARA] (DOMPARAMET, DOMPARAUSU, DOMPARAFEC, DOMPARADIP, DOMPARACOD, DOMPARAEST, DOMPARATST, DOMPARAORD, DOMPARAPC1, DOMPARAPC2, DOMPARAPC3, DOMPARADIC, DOMPARADIO, DOMPARADIU, DOMPARAADJ, DOMPARAOBS)
		SELECT 'UPDATE AFTER', i.DOMPARAUS, GETDATE(), i.DOMPARAIP, i.DOMPARCOD, i.DOMPAREST, i.DOMPARTST, i.DOMPARORD, i.DOMPARPC1, i.DOMPARPC2, i.DOMPARPC3, i.DOMPARDIC, i.DOMPARDIO, i.DOMPARDIU, i.DOMPARADJ, i.DOMPAROBS FROM INSERTED i;
	END
GO

CREATE TRIGGER [adm].[DOMPAR_DELETE] 
	ON [adm].[DOMPAR]
	AFTER DELETE
	AS
	BEGIN
		SET NOCOUNT ON;
		INSERT INTO [adm].[DOMPARA] (DOMPARAMET, DOMPARAUSU, DOMPARAFEC, DOMPARADIP, DOMPARACOD, DOMPARAEST, DOMPARATST, DOMPARAORD, DOMPARAPC1, DOMPARAPC2, DOMPARAPC3, DOMPARADIC, DOMPARADIO, DOMPARADIU, DOMPARAADJ, DOMPARAOBS)
		SELECT 'DELETE BEFORE', d.DOMPARAUS, GETDATE(), d.DOMPARAIP, d.DOMPARCOD, d.DOMPAREST, d.DOMPARTST, d.DOMPARORD, d.DOMPARPC1, d.DOMPARPC2, d.DOMPARPC3, d.DOMPARDIC, d.DOMPARDIO, d.DOMPARDIU, d.DOMPARADJ, d.DOMPAROBS FROM DELETED d;
	END
GO