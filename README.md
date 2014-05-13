Kata Data Transformers
========================

#### As a user, I need to link Tags to my Article.

```
[x] Add a way to add Tags in the form Article.
[x] Link a Tag to an Article if he already exists.
[x] Tags are represented as text with space between other Tags.
[x] Tests dataTransformer.
```

### Steps :

1. Create another entity Tag with a title. Who have a ManyToMany relationShip with entity Article.
2. Create a ModelTransformer class who implements `DataTransformerInterface`.
3. Inject him ObjectManager.
4. Implements `transform` and `reverseTransform` method for converting an arrayCollection to an simple array and conversely
5. In `reverseTransform` method if a tag don't exist, persit a new one with ObjectManager. If not, link to Article.
6. Create a ViewTransformer class who implements `DataTransformerInterface`.
7. Implements `transform` and `reverseTransform` method for converting an array to a string with space and conversely.
You can use `explode` and `implode` function.
8. Now create a custom field type for tags, create a class `TagType` who implements `AbstractType`.
9. Set your dataTransformers directly in your custom field in the `buildForm` method. Like
`$builder->addViewTransformer($viewTransformer)->addModelTransformer($modelTransformer);`.
10. Then register your custom filed as a service and tag it with `form.type` so that it's recognized as a custom field type.
11. Now you can set your field `'tags'` and use your custom field in your ArticleType form, like
`->add('tags', 'tags_selector')`
