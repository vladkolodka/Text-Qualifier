# Text Qualifier
*version 1.0*

Текстовый категоризатор. Использует латентно-семантический анализ для определения схожести текстов.

На основе текстов (хранятся в базе данных), которые прикреплены к тематикам, производит сравнение текста пользователя и определяет наиболее семантически близкие тематики.

+ Многоязычность сайта (`Украинский, Русский, English`)
+ Панель управления
  + Уравление тематиками
    + Добавлеение
    + Просмотр
    + Просмотр документов тематики
  + Упрвалеение документами
    + Добавление
    + Просмотр
+ Категоризация русскоязычных и англоязычных текстов
+ Самообучение на основе текстов пользователей

__Поддерживаемые форматы текстовых документов:__
+ DOC
+ DOCX
+ ODT
+ TXT
+ PDF

##Используемые библиотеки
+  Laravel *v5.2*
+ Materialize
+ jQuery
+ phpMorphy

## TODO
- [ ] Seed стоп-слов
- [ ] Страницы About, Help
- [ ] Автонаполнение базы данных текстами
- [ ] Удаление тематик
- [ ] Удаление текстов
- [ ] Утилиты
   - [ ] Страница утилит
   - [ ]  Удаление не используемых слов