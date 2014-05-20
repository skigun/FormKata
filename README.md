Kata Form Data Mapper
======================

#### As a user, I need to edit an article defined in an xml document.

```
[X] The initial form data should be provided by an xml document.
[X] Make a custom xml data mapper.
[X] Save the submitted data into the xml document.
[X] Add tests.

```

### Steps :

1. Make a blank xml file with `<article>` as root node.
2. In your controller load the xml document with `simplexml_load_file` and pass it to the `createForm` method as second argument.
3. Create the `XmlDocumentMapper` class implementing `DataMapperInterface`
4. Implement `mapDataToForms()` method to fill the form data with the xml data, you can access to the data value with `(string) $data->$propertyPath`
5. Implement `mapFormsToData()` method to fill xml data with the form data `$data->$propertyPath = $form->getData();`
6. In `ArticleType` set your dataMapper to the builder.
7. If the form is valid save the xml using the `saveXml` method with the file path as argument.
