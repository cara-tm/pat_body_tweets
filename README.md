# pat-body-tweets

Textpattern CMS plugin.

Add Twitter links into your text content like the comment system into the [Medium's website](http://medium.com) (optional). Allow visitors to Tweet parts of text content on mouse selection as shown on [The (New) Guardian](http://next.theguardian.com) website (optional). Note: These two tags are independents.

## Add an icon for Twitter in front of each text parts (generate an individual anchor into each Tweets)
**All followed tags are intended to be used as single ones, not container ones**.

**Usage (all browsers capable)**:

    <txp:pat_body_tweets tag="" full="" sign="" tooltip="" class="" content="" />

## Allow your visitors to Tweet parts of your text content on mouse selection (do not generate any anchors, just article URL into the Tweets)

**Usage (IE9+ & all modern browsers capable)**

Place this code into your page template just before the last <code>&lt;/body&gt;</code> HTML tag:

    <txp:pat_body_tweets_live id="" account="" label="" popup="" info="" tooltip="" position="" top="" right="" bottom="" color="" />

