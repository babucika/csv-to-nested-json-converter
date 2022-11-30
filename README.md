# csv-to-nested-json-converter

To convert a csv file to neseted json do the following steps:

1. Create a csv file in the following format. The column headers must be the nested keys concatenated by "__":

   variablesToBeUpdated__id|expectedResult__statusCodeTest__testName|expectedResult__statusCodeTest__code|expectedResult__responseBodyTest__testName|expectedResult__responseBodyTest__body__code|expectedResult__responseBodyTest__body__detail|expectedResult__responseBodyTest__body__message
   --- | --- | --- | --- |--- |--- |--- 
   365|Status code if 'id' datatype is invalid|400|Response body if 'id' datatype is invalid|400|id must be of type string|id must be of type string

2. Run the following command. The csv specified in the first argument will be converted to nested json. The nested json file will be created as specified in the second argument.
```
php convertCsvToJson.php path_to_csv_file path_to_json_file
```

3. If you open the created json file you should see something like:
```javascript
[
    {
        "variablesToBeUpdated": {
            "id": 365
        },
        "expectedResult": {
            "statusCodeTest": {
                "testName": "Status code if 'id' datatype is invalid",
                "code": 400
            },
            "responseBodyTest": {
                "testName": "Response body if 'id' datatype is invalid",
                "body": {
                    "code": 400,
                    "detail": "id must be of type string",
                    "message": "id must be of type string"
                }
            }
        }
    }
]
```