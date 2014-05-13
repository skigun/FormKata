Kata Form type extension
========================

#### As a user, i need to see help message on the article form.

```
[X] Create a new form type extension.
[X] The help message is an optional string and can be set on all field.
[X] Override the twig theme in order to display the help message.
```
1. Create the `HelpMessageExtension` class extending `AbstractTypeExtension`.
2. Implement `getExtendedType` to return the `form` type.
2. Override `setDefaultOptions` to make the help message optional and set the allowed type `string`.
3. Override `buildView` in order to add the help message into the `FormView`.
4. Make the service with the `form.type_extension` tag and `form` as alias.
5. In `ArticleType` add some help messages to the fields.
6. Create a new template in `views/Form/fields.html.twig` which extends `form_div_layout.html.twig`.
7. Override the `form_widget` and the `textarea_widget` in order to display the help message if defined.
8. Import the theme in your twig view. `{% form_theme form 'Acme...'%}`
