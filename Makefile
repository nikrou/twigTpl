# use to deploy to my local server
DIST=.dist
PLUGIN_NAME=twigTpl
SOURCE=./*
TARGET=target
DESTINATION=/var/www/dc/dotclear/plugins/$(PLUGIN_NAME)/
RSYNC=rsync -vrpcC --exclude-from=rsync_exclude

rsync:
	$(RSYNC) $(SOURCE) $(DESTINATION) -n
install:
	$(RSYNC) $(SOURCE) $(DESTINATION)

config: clean manifest
	mkdir -p $(DIST)/$(PLUGIN_NAME)
	mkdir -p $(TARGET)
	cp -pr $(SOURCE) $(DIST)/$(PLUGIN_NAME)
	find $(DIST) -name '*~' -exec rm \{\} \;

dist: config composer
	cd $(DIST);									\
	rm -fr twigTpl/vendor/twig/twig/test twigTpl/vendor/twig/twig/doc;		\
	rm -fr twigTpl/vendor/twig/extensions/test twigTpl/vendor/twig/extensions/doc;	\
	rm -fr twigTpl/vendor/twig/twig/ext; \
	zip -v -i@$(PLUGIN_NAME)/MANIFEST -r9 ../$(TARGET)/plugin-$(PLUGIN_NAME)-$$(grep Version ./$(PLUGIN_NAME)/_define.php | cut -d "'" -f2).zip $(PLUGIN_NAME)/*; \
	cd ..

composer:
	test -f composer.phar || curl -sS https://getcomposer.org/installer | php
	./composer.phar install --no-dev

manifest:
	@find ./ -type f|egrep -v '(*~|.git|.dist|target|resource|modele|Makefile|rsync_exclude)'|sed -e 's/\.\///' -e 's/\(.*\)/$(PLUGIN_NAME)\/&/'> ./MANIFEST

clean:
	rm -fr $(DIST)

dist-clean:
	rm -fr $(DESTINATION)*
