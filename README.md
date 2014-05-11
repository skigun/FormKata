Form Kata
=========

#### As a user, i need to dynamically add categories to my article.

```
[X] Make a Category entity and set the relationship with Article.
[X] Embed a collection of category form into the article form.
[X] Add javascript logic in order to dynamically add new a category.
[X] Add javascript logic in order to dynamically remove a category.
[X] Remove the deleted category from database.
[X] Add functional tests
```

1. Create a `Category` class (id, name fields) and set a `ManyToMany` unidirectional relationship in the `Article` class (categories should be an `ArrayCollection`) with getter/setter and adder/remover.
2. Create a new FormType service for the `Category` entity.
3. Add `categories` field using `collection` type to the form builder in `ArticleType`.
4. Inside your form template add `<ul class="categories" data-prototype="{{ form_widget(form.categories.vars.prototype)|e }}"></ul>`, it will be used to add a new categorie form.
5. Add JQuery library
6. Create a javascript function which will get the form prototype `$('ul.categories').data('prototype')` and will append it into a new element in the list (dont forget to replace `__name__` in the prototype's HTML by the length of the list).
7. Add a link `Add a Category` with a listener to `click` event which will fire the previous function.
8. In `ArticleType`, add a `by_reference` option to false for the `categories` field (it will force the use of the adder/remover)
9. In the `Article` entity, add a `cascade={"persist"}` to automatically persist any related categories.
10. You are now able to add a new article with multiple categories, now we want to remove a particular category.
11. In `ArticleType` add `allow_add` and `allow_delete` option to true
12. Create a new javascript function `addDeleteLink(categoryForm)` which will append a delete link for a category form, this function will be called for each existing categories and when a new category form is added.
13. The delete link will have a listener to the click event, which will delete the current form element in the list with `categoryForm.remove()`.
14. Now we want ensure that the deleted category is also removed from database. Create an editAction() in your controller.
15. Then create an ArrayCollection of the categories before the request handling `new ArrayCollection($article->getCategories()->toArray());`.
16. After the form validation, do a foreach loop on your original categories and check if your updated article contains the original categories, if not, remove the category entirely `$em->remove($category);`.

#### Launch tests
```
casperjs test src/Acme/KataBundle/Tests/Casperjs/tests.js --url=YOUR_URL/app_dev.php
```
