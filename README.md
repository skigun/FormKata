Kata Form Theming
=================

#### As a user, I need to see a pretty form with some nice customizations.

```
[x] See an aligned form.
[x] Adding a "Required" Asterisk to Field Labels
```

### Steps :
1. Create a custom template in `views\Form\fields.html.twig`
2. Twig set the form resource in config.yml:
```
twig:
    form:
        resources: ['AcmeKataBundle:Form:fields.html.twig']
```
3. In your template extend from `form_table_layout.html.twig`
4. Now override the block `form_label` and add if `required` is true, an Asterisk like
`<span class="myClass">*</span>`
