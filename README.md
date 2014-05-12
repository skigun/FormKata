Kata Data Transformers
========================

#### As a user, I need to link Tags to my Artcile.

```
[x] Add a way to add Tags in the form Article.
[x] Link a Tag to an Article if he already exists.
[x] Tags are represented as text with space between other Tags.
```

### Steps :

1. Create another entity Tag with a title. Who have a ManyToMany relastionShip with entity Article.
2. Create a dataTransformers class who implements `DataTransformerInterface`.
3. Inject him ObjectManager.
4. Implements `transform` and `reverseTransform` method for converting a text field into tags. Use `explode` function.
5. In `reverseTransform` if a tag don't exist, persit a new one with ObjectManager. If not, link  to Article.
6. Add tags field in form Article with the dataTransformers.
7. Now create a custom field type for tags, create a class `TagType` who implements `AbstractType`.
8. Set your dataTransfomer directly in your custom field in the `buildForm` method.
9. Then register your custom filed as a service and tag it with `form.type` so that it's recognized as a custom field type.
10. Now you replace your field `'tags'` and use your custom field in your ArticleType form, like
`->add('tags', 'tags_selector')`
