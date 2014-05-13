Kata Form Events
========================

#### As a user, I need to link Tags to my Article.

```
[x] Add a way to add Tags in the form Article.
[x] Link a Tag to an Article if he already exists.
[x] Tags are represented as text with space between other Tags.
```

### Steps :

1. Create another entity Tag with a title. Who have a ManyToMany relationShip with entity Article.
2. Create a Subscriber class who implements `EventSubscriberInterface`.
3. Inject entityManager with the constructor method.
4. Define two events in getSubscribedEvents method `FormEvents::PRE_SET_DATA => 'preSetData'`
and `FormEvents::POST_SUBMIT => 'postSubmit'`.
5. In `preSetData` method get Article and add a text field tags with the titles of tags separate by space.
Use `$event->getData()` for retrieving Article, and use `$event->getForm()` for retrieving the form.
6. In `postSubmit` retrieve titles of Tags, test if they already exist in base, if not create them and set all tags to the current Article.
Don't need to `flush()` just set the tags like `$article->setTags($tags);`.
7. Now inject entityManager to the ArticleType in your service declaration. `<argument type="service" id="doctrine.orm.entity_manager"/>`.
8. Then add your subscriber `->addEventSubscriber(new TagFieldSubscriber($this->em))` to your `ArticleType`, don't forget to inject em.
