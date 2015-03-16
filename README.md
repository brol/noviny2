# Noviny2
Fork de Noviny de Olivier Meunier pour Dotclear 2

Codes par défaut de select, overview et news
--------------------------------------------

select :

```html
<tpl:Categories>
  <tpl:LoopPosition start="1" length="1">
    <tpl:Entries lastn="1">
      {{tpl:EntryFirstImage size="s" class="front" with_category="1"}}
      <div class="block">
      <p class="category-title"><a href="{{tpl:CategoryURL}}">{{tpl:CategoryTitle encode_html="1"}}</a></p>
      <h2><a href="{{tpl:EntryURL}}">{{tpl:EntryTitle encode_html="1"}}</a></h2>
      <!-- # Entry with an excerpt -->
      <tpl:EntryIf extended="1">
        <div class="post-content">{{tpl:EntryExcerpt}}</div>
      </tpl:EntryIf>
      <!-- # Entry without excerpt -->
      <tpl:EntryIf extended="0">
        <div class="post-content"><p>{{tpl:EntryContent encode_html="1" remove_html="1" cut_string="500"}}</p></div>
      </tpl:EntryIf>
      <p class="read-it"><a href="{{tpl:EntryURL}}"
      title="{{tpl:lang Continue reading}} {{tpl:EntryTitle encode_html="1"}}">{{tpl:lang Continue reading}}</a>
        <tpl:EntryIf operator="or" show_comments="1" show_pings="1">
        <span class="comment-count"><span> | {{tpl:lang Comments:}}</span>
          <a href="{{tpl:EntryURL}}#comments" title="{{tpl:EntryCommentCount count_all="1"}}">{{tpl:EntryCommentCount count_all="1" none="%s" one="%s" more="%s"}}</a></span>
        </tpl:EntryIf>
      </p>
      </div>
    </tpl:Entries>
  </tpl:LoopPosition>
</tpl:Categories>
```

overview :

```html
<tpl:Categories level="1"><tpl:LoopPosition start="2">
<tpl:Entries category="#self ?sub" lastn="1" no_context="1">
  <div id="p{{tpl:EntryID}}" class="block post {{tpl:EntryIfOdd}} {{tpl:EntryIfFirst}}" lang="{{tpl:EntryLang}}" role="article">
  {{tpl:EntryFirstImage size="sq" class="front" with_category="1"}}
  <p class="category-title"><a href="{{tpl:CategoryURL}}">{{tpl:CategoryTitle encode_html="1"}}</a></p>
  <h2 class="post-title"><a href="{{tpl:EntryURL}}">{{tpl:EntryTitle encode_html="1"}}</a></h2>
    <!-- # Entry with an excerpt -->
    <tpl:EntryIf extended="1">
    <div class="post-content">{{tpl:EntryExcerpt}}</div>
    </tpl:EntryIf>
    <!-- # Entry without excerpt -->
    <tpl:EntryIf extended="0">
      <div class="post-content"><p>{{tpl:EntryContent encode_html="1" remove_html="1" cut_string="250"}}</p></div>
    </tpl:EntryIf>
    <p class="read-it"><a href="{{tpl:EntryURL}}"
    title="{{tpl:lang Continue reading}} {{tpl:EntryTitle encode_html="1"}}">{{tpl:lang Continue reading}}</a>
      <tpl:EntryIf operator="or" show_comments="1" show_pings="1">
      <span class="comment-count"><span> | {{tpl:lang Comments:}}</span>
        <a href="{{tpl:EntryURL}}#comments" title="{{tpl:EntryCommentCount count_all="1"}}">{{tpl:EntryCommentCount count_all="1" none="%s" one="%s" more="%s"}}</a></span>
      </tpl:EntryIf>
    </p>
  </div>
</tpl:Entries>
</tpl:LoopPosition></tpl:Categories>
```

news :

```html
<tpl:Entries no_category="1" lastn="3">
  <tpl:EntriesHeader><div class="news"><h2>{{tpl:lang Breaking news}}</h2></tpl:EntriesHeader>
  <h3><a href="{{tpl:EntryURL}}">{{tpl:EntryTitle encode_html="1"}}</a></h3>
  <p>{{tpl:EntryContent encode_html="1" remove_html="1" cut_string="120"}}...
    <tpl:EntryIf operator="or" show_comments="1" show_pings="1">
    <span class="comment-count"><span> | {{tpl:lang Comments:}}</span>
      <a href="{{tpl:EntryURL}}#comments" title="{{tpl:EntryCommentCount count_all="1"}}">{{tpl:EntryCommentCount count_all="1" none="%s" one="%s" more="%s"}}</a></span>
    </tpl:EntryIf>
  </p>
  <tpl:EntriesFooter></div></tpl:EntriesFooter>
</tpl:Entries>
```