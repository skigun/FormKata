var url = casper.cli.get("url");

require("utils").dump(url);

casper.test.begin('Embed form collection tests', 9, function(test) {
    casper.start(url).then(function() {
        test.info('On '+ url +'/ we have an article form:');
        test.assertElementCount('form[name="article"]', 1);
        test.info('Click on Add a category.');
    });

    casper.thenClick('a[class="add_category_link"]');

    casper.then(function() {
        test.info('We see a new category input:');
        test.assertElementCount('input[name="article[categories][0][name]"]', 1);
        test.info('Click on Add a category.');
    });

    casper.thenClick('a[class="add_category_link"]');

    casper.then(function() {
        test.info('We see a second category input:');
        test.assertElementCount('input[name="article[categories][1][name]"]', 1);
    });

    casper.then(function() {
        test.info('We fill and submit the form.');
        this.fill('form[name="article"]', {
            'article[title]': 'title',
            'article[content]': 'content',
            'article[author]': 'toto',
            'article[categories][0][name]': 'Categorie 1',
            'article[categories][1][name]': 'Categorie 2'
        }, true);
    });

    casper.then(function() {
        test.info('We are redirected to the edit form:');
        this.test.assertField('article[title]', 'title');
        this.test.assertField('article[content]', 'content');
        this.test.assertField('article[author]', 'toto');
        this.test.assertField('article[categories][0][name]', 'Categorie 1');
        this.test.assertField('article[categories][1][name]', 'Categorie 2');
        test.info('Click on Delete a category link of Categorie 1.');
    });

    casper.thenClick('a[class="delete_category_link"]');

    casper.then(function() {
        test.info('We only have Categorie 2 left:');
        this.test.assertField('article[categories][0][name]', null);
        this.test.assertField('article[categories][1][name]', 'Categorie 2');
    });
});

casper.run();
