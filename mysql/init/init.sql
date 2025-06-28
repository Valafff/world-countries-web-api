-- создание таблицы стран
CREATE TABLE country_t (
	id INT NOT NULL AUTO_INCREMENT,
    short_name_f NVARCHAR(255) NOT NULL,
    full_name_f NVARCHAR(255) NOT NULL,
    isoAlpha2_f CHAR(2) NOT NULL,
    isoAlpha3_f CHAR(3) NOT NULL,
    isoNumeric_f INT NOT NULL,
    population_f BIGINT NOT NULL,
    square_f DOUBLE  NOT NULL,
    --
    PRIMARY KEY(id),
    UNIQUE(isoAlpha2_f),
    UNIQUE(isoAlpha3_f),
    UNIQUE(isoNumeric_f),
    UNIQUE(full_name_f),
    UNIQUE(short_name_f)
);

-- добавить данные
INSERT INTO country_t (
	short_name_f,
    full_name_f,
    isoAlpha2_f,
    isoAlpha3_f,
    isoNumeric_f,
    population_f,
    square_f
) VALUES 
    (N'Россия', N'Российская Федерация', 'RU', 'RUS', 643, 146150789, 17125191),
    (N'США', N'Соединённые Штаты Америки', 'US', 'USA', 840, 331002651, 9372610),
    (N'Китай', N'Народная Республика Китай', 'CN', 'CHN', 156, 1439323776, 9596961),
    (N'Индия', N'Республика Индия', 'IN', 'IND', 356, 1380004385, 3287263),
    (N'Бразилия', N'Бразильская Республика', 'BR', 'BRA', 76, 212559417, 8515767),
    (N'Австралия', N'Содружество Австралия', 'AU', 'AUS', 36, 25499884, 7692024),
    (N'Канада', N'Канада', 'CA', 'CAN', 124, 37742154, 9984670),
    (N'Германия', N'Федеративная Республика Германия', 'DE', 'DEU', 276, 83783942, 357022),
    (N'Франция', N'Французская Республика', 'FR', 'FRA', 250, 65273511, 551695),
    (N'Япония', N'Япония', 'JP', 'JPN', 392, 126476461, 377975);
