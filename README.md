# ExcelFile Controller

A controller where you can upload any Excel file which will be stored in database and can be rendered on screen with added functionality like search and sorting.

## Usage

- Clone git repo
- Run seeder

## Functionality 

- Upload any given Excel file (regardless of number of columns/rows and names of columns/rows). It will be parsed, converted to JSON, and saved to the database. 

- A fetch button, which uses AJAX to fetch the latest Excel file JSON content from the database, parse it and render it in a table. 

- The table have search as well as sorting for all columns (one input searches and filters all columns).


## Limitations

The following is the limitation : 

- Table header value or search key is case sensitive.

## Future agenda

The following are my future agendas :


- When file gets uploaded successfully, then dynamically create drop down of header values for easy of searching.

- Optimize the code by implementing the use of DataTable using JQuery Plugin so that user defined searching and sorting  methods not required and boilerplate code can be reduced.
