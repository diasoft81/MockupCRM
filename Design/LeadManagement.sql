USE [CRM_SPM]
GO
/****** Object:  Table [mst].[Companies]    Script Date: 15/05/2025 07:17:08 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [mst].[Companies](
	[Id] [nchar](36) NOT NULL,
	[CompanyShortName] [nvarchar](10) NULL,
	[CompanyName] [nvarchar](200) NULL,
	[CompanyEmail] [nvarchar](200) NULL,
	[CompanyAddress] [nvarchar](200) NULL,
	[CompanyRegion] [nvarchar](50) NULL,
	[CompanyCity] [nvarchar](50) NULL,
	[CompanyLatitude] [money] NULL,
	[CompanyLongitude] [money] NULL,
	[CompanyPhone] [nvarchar](50) NULL,
	[CompanyTaxId] [nvarchar](50) NULL,
	[CompanyBank] [nvarchar](50) NULL,
	[CompanyBankAcc] [nvarchar](50) NULL,
	[IndustrySegment] [nvarchar](100) NULL,
	[CustomerCategory] [nvarchar](100) NULL,
	[AdditionalNotes] [nvarchar](max) NULL,
	[Status] [nvarchar](100) NULL,
	[LastBy] [nchar](36) NULL,
	[LastDate] [datetime] NULL,
 CONSTRAINT [PK__Companie__3214EC07967807C7] PRIMARY KEY CLUSTERED 
(
	[Id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [mst].[ContactPersons]    Script Date: 15/05/2025 07:17:08 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [mst].[ContactPersons](
	[Id] [nchar](36) NOT NULL,
	[Name] [nvarchar](200) NULL,
	[Email] [nvarchar](200) NULL,
	[Phone] [nvarchar](50) NULL,
	[Mobile] [nvarchar](50) NULL,
	[Address] [nvarchar](200) NULL,
	[Region] [nvarchar](50) NULL,
	[City] [nvarchar](50) NULL,
	[Latitude] [money] NULL,
	[Longitude] [money] NULL,
	[Status] [nvarchar](100) NULL,
	[LastBy] [nchar](36) NULL,
	[LastDate] [datetime] NULL,
 CONSTRAINT [PK__ContactP__3214EC0764935987] PRIMARY KEY CLUSTERED 
(
	[Id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [ref].[Products]    Script Date: 15/05/2025 07:17:08 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [ref].[Products](
	[Id] [nchar](36) NOT NULL,
	[Type] [nvarchar](100) NOT NULL,
	[Merk] [nvarchar](100) NOT NULL,
	[Model] [nvarchar](100) NOT NULL,
	[Description] [nvarchar](max) NULL,
	[Quantity] [int] NOT NULL,
	[CostPrice] [money] NULL,
	[LowerBound] [money] NULL,
	[UpperBound] [money] NULL,
	[DiscountedPrice] [money] NULL,
	[LastBy] [nchar](36) NULL,
	[LastDate] [datetime] NULL,
 CONSTRAINT [PK__Product__3214EC07BC91109C] PRIMARY KEY CLUSTERED 
(
	[Id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [trx].[LeadProducts]    Script Date: 15/05/2025 07:17:08 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [trx].[LeadProducts](
	[Id] [nchar](36) NOT NULL,
	[LeadId] [nchar](36) NULL,
	[ProductId] [nchar](36) NULL,
	[Quantity] [int] NULL,
	[UnitPrice] [money] NULL,
	[TotalPrice] [money] NULL,
	[Status] [nvarchar](100) NULL,
	[LastBy] [nchar](36) NULL,
	[LastDate] [datetime] NULL,
 CONSTRAINT [PK__LeadProd__3214EC07359DB82C] PRIMARY KEY CLUSTERED 
(
	[Id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [trx].[Leads]    Script Date: 15/05/2025 07:17:08 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [trx].[Leads](
	[Id] [nchar](36) NOT NULL,
	[CompanyId] [nchar](36) NULL,
	[ContactId] [nchar](36) NULL,
	[LeadName] [nvarchar](100) NULL,
	[LeadStatus] [nvarchar](100) NULL,
	[LeadSource] [nvarchar](100) NULL,
	[CurrentStage] [nvarchar](100) NULL,
	[ExpectedCloseDate] [datetime] NULL,
	[CloseDate] [datetime] NULL,
	[Amount] [money] NULL,
	[Status] [nvarchar](100) NULL,
	[LastBy] [nchar](36) NULL,
	[LastDate] [datetime] NULL,
 CONSTRAINT [PK__Leads__3214EC07E6BFB76A] PRIMARY KEY CLUSTERED 
(
	[Id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
ALTER TABLE [mst].[Companies] ADD  CONSTRAINT [DF__Companies__LastD__778AC167]  DEFAULT (getdate()) FOR [LastDate]
GO
ALTER TABLE [mst].[ContactPersons] ADD  CONSTRAINT [DF__ContactPe__LastD__7A672E12]  DEFAULT (getdate()) FOR [LastDate]
GO
ALTER TABLE [ref].[Products] ADD  CONSTRAINT [DF__Product__Id__45F365D3]  DEFAULT (newid()) FOR [Id]
GO
ALTER TABLE [ref].[Products] ADD  CONSTRAINT [DF__Product__Quantit__46E78A0C]  DEFAULT ((0)) FOR [Quantity]
GO
ALTER TABLE [ref].[Products] ADD  CONSTRAINT [DF__Product__LastDat__47DBAE45]  DEFAULT (getdate()) FOR [LastDate]
GO
ALTER TABLE [trx].[LeadProducts] ADD  CONSTRAINT [DF__LeadProdu__LastD__74AE54BC]  DEFAULT (getdate()) FOR [LastDate]
GO
ALTER TABLE [trx].[Leads] ADD  CONSTRAINT [DF__Leads__LastDate__71D1E811]  DEFAULT (getdate()) FOR [LastDate]
GO
ALTER TABLE [mst].[Companies]  WITH CHECK ADD  CONSTRAINT [FK_Companies_Users] FOREIGN KEY([LastBy])
REFERENCES [dbo].[Users] ([Id])
GO
ALTER TABLE [mst].[Companies] CHECK CONSTRAINT [FK_Companies_Users]
GO
ALTER TABLE [mst].[ContactPersons]  WITH CHECK ADD  CONSTRAINT [FK_ContactPersons_Users] FOREIGN KEY([LastBy])
REFERENCES [dbo].[Users] ([Id])
GO
ALTER TABLE [mst].[ContactPersons] CHECK CONSTRAINT [FK_ContactPersons_Users]
GO
ALTER TABLE [ref].[Products]  WITH CHECK ADD  CONSTRAINT [FK_Products_Users] FOREIGN KEY([LastBy])
REFERENCES [dbo].[Users] ([Id])
GO
ALTER TABLE [ref].[Products] CHECK CONSTRAINT [FK_Products_Users]
GO
ALTER TABLE [trx].[LeadProducts]  WITH CHECK ADD  CONSTRAINT [FK_LeadProducts_Leads] FOREIGN KEY([LeadId])
REFERENCES [trx].[Leads] ([Id])
GO
ALTER TABLE [trx].[LeadProducts] CHECK CONSTRAINT [FK_LeadProducts_Leads]
GO
ALTER TABLE [trx].[LeadProducts]  WITH CHECK ADD  CONSTRAINT [FK_LeadProducts_Products] FOREIGN KEY([ProductId])
REFERENCES [ref].[Products] ([Id])
GO
ALTER TABLE [trx].[LeadProducts] CHECK CONSTRAINT [FK_LeadProducts_Products]
GO
ALTER TABLE [trx].[LeadProducts]  WITH CHECK ADD  CONSTRAINT [FK_LeadProducts_Users] FOREIGN KEY([LastBy])
REFERENCES [dbo].[Users] ([Id])
GO
ALTER TABLE [trx].[LeadProducts] CHECK CONSTRAINT [FK_LeadProducts_Users]
GO
ALTER TABLE [trx].[Leads]  WITH CHECK ADD  CONSTRAINT [FK_Leads_Companies] FOREIGN KEY([CompanyId])
REFERENCES [mst].[Companies] ([Id])
GO
ALTER TABLE [trx].[Leads] CHECK CONSTRAINT [FK_Leads_Companies]
GO
ALTER TABLE [trx].[Leads]  WITH CHECK ADD  CONSTRAINT [FK_Leads_ContactPersons] FOREIGN KEY([ContactId])
REFERENCES [mst].[ContactPersons] ([Id])
GO
ALTER TABLE [trx].[Leads] CHECK CONSTRAINT [FK_Leads_ContactPersons]
GO
ALTER TABLE [trx].[Leads]  WITH CHECK ADD  CONSTRAINT [FK_Leads_Users] FOREIGN KEY([LastBy])
REFERENCES [dbo].[Users] ([Id])
GO
ALTER TABLE [trx].[Leads] CHECK CONSTRAINT [FK_Leads_Users]
GO
