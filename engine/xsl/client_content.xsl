<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0" xmlns:php="http://php.net/xsl">
  <xsl:include href="../../modules/catalogue/client_catalogue.xsl"/>
  <xsl:include href="../../modules/catalogue1/client_catalogue1.xsl"/>
  <xsl:include href="../../modules/gallery/client_gallery.xsl"/>  
  <xsl:include href="../../modules/baners/client_baners.xsl"/>
  <xsl:include href="../../modules/question/client_question.xsl"/>
  <xsl:include href="../../modules/messages/client_messages.xsl"/>
  <xsl:include href="../../modules/links_exchange/client_links_exchange.xsl"/>  
  <xsl:include href="../../modules/comments/client_comments.xsl"/>  
  
  <xsl:template match="content">
    <xsl:choose>
      <xsl:when test="//section/node/current_id=1 and //section/node/current_module!='search'">
        <xsl:call-template name="content_main"/>
      </xsl:when>
      <xsl:otherwise>
        <xsl:call-template name="content_second"/>
      </xsl:otherwise>
    </xsl:choose>
  </xsl:template>

  <xsl:template name="content_main">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="440" width="397" valign="top" class="abc_block" align="left">
          <!--div id="tov"><img src="images/to.jpg" width="41" height="159" /></div-->
          <div align="left" style="width:397px; position:relative; top: 0px">
            <xsl:for-each select="//content/list_articles/articles_anons/list[id_section=17]">
            <div style="padding:10px">
              <a href="?section=17&amp;item={id}" class="text11">
                <xsl:value-of select="title" disable-output-escaping="yes"/>
              </a>
              <a href="?section=17&amp;item={id}" class="text11">
                <xsl:value-of select="anons" disable-output-escaping="yes"/>
              </a>
            </div>
              <xsl:if test="position()!=last()">
            <img src="images/sparator.gif" width="397" height="12" />
              </xsl:if>
            </xsl:for-each>
          </div>                      </td>
        <td class="usl" width="321" valign="top" align="left" style="padding-top:15px">
          <div class="nb"><div id="tov3"><img src="images/3gif.gif" /></div></div>
          <div align="left" style="margin-left:20px; width:270px">
            <strong class="text12">
              <xsl:value-of select="//content/list_articles/articles_anons/list/title[../id_section=18]" disable-output-escaping="yes"/>
            </strong>
            <span class="text13">
              <xsl:value-of select="//content/list_articles/articles_anons/list/anons[../id_section=18]" disable-output-escaping="yes"/>
            </span>
          </div>
          <div style="padding: 10px; width: 275px;" align="left">
            <!--img src="images/oe_bb.jpg" /-->
            <p><span class="text13"><strong class="text12">
              <xsl:value-of select="//content/list_articles/articles_anons/list/title[../id_section=19]" disable-output-escaping="yes"/>
            </strong></span></p>
            <p><span class="text13">
              <xsl:value-of select="//content/list_articles/articles_anons/list/anons[../id_section=19]" disable-output-escaping="yes"/>
            </span></p>
          </div>
        </td>
      </tr>
    </table>
  </xsl:template>

<xsl:template name="content_second">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="440" align="left" valign="top" bgcolor="#F1EAD8" class="usl2">
        <div class="text21">
          <xsl:call-template name="mites">
            <xsl:with-param name="id" select="//section/node/current_id"/>
          </xsl:call-template>
        </div>
        <div class="text13">
        <xsl:call-template name="second_menu"/>&#160;
        </div>
        <div class="text13">
        <xsl:call-template name="content"/>
        </div>
        </td>
    </tr>
  </table>
</xsl:template>
  
  <xsl:template name="mites">
    <xsl:param name="id"/>
    <xsl:param name="path"/>
    <xsl:choose>
      <xsl:when test="//section/node/node/add/id_parent[../../node[1]=$id] != ''">
        <xsl:call-template name="mites">
          <xsl:with-param name="id" select="//section/node/node/add/id_parent[../../node[1]=$id]"/>
          <xsl:with-param name="path">
           >> &lt;a href="?section=<xsl:value-of select="$id"/>"><xsl:value-of select="//section/node/node/add/name[../../node[1]=$id]"/>&lt;/a> <xsl:value-of select="$path"/>
          </xsl:with-param>
        </xsl:call-template>
      </xsl:when>
      <xsl:otherwise>
        <a href="?section={$id}"><xsl:value-of select="//section/node/node/add/name[../../node[1]=$id]"/></a><xsl:value-of select="$path" disable-output-escaping="yes"/>
      </xsl:otherwise>
    </xsl:choose>
  </xsl:template>
  
  <!--xsl:template name="mites">
    <xsl:param name="parent"/>
    <xsl:param name="id"/>
    <xsl:param name="path"/>
  </xsl:template-->

  <xsl:template name="content">
            <xsl:choose>
              <xsl:when test="//section/node/current_module='news'">
                <xsl:apply-templates select="news"/>
              </xsl:when>
              <xsl:when test="//section/node/current_module='articles_with_anons'">
                <xsl:apply-templates select="articles_with_anons"/>
              </xsl:when>
              <xsl:when test="//section/node/current_module='catalogue'">
                <xsl:apply-templates select="catalogue"/>
              </xsl:when>
              <xsl:when test="//section/node/current_module='catalogue1'">
                <xsl:apply-templates select="catalogue1"/>
              </xsl:when>
              <xsl:when test="//section/node/current_module='gallery'">
                <xsl:apply-templates select="gallery"/>
              </xsl:when>
              <xsl:when test="//section/node/current_module='links_exchange'">
                <xsl:apply-templates select="links_exchange"/>
              </xsl:when>
              <xsl:when test="//section/node/current_module='messages'">
                <xsl:apply-templates select="messages"/>
              </xsl:when>
              <xsl:when test="//section/node/current_module='map'">
                <xsl:call-template name="map"/>
              </xsl:when>              
              <xsl:when test="//section/node/current_module='baners'">
                <xsl:apply-templates select="baners"/>
              </xsl:when>              
              <xsl:when test="//section/node/current_module='search'">
                <xsl:apply-templates select="find"/>
              </xsl:when>
              <xsl:when test="//section/node/current_module='question'">
                <xsl:apply-templates select="question"/>
              </xsl:when>
              <xsl:otherwise>
                <xsl:apply-templates select="list_articles"/>
              </xsl:otherwise>
            </xsl:choose>
    <!-- Text razdela end !-->
  </xsl:template>

  <xsl:template match="list_articles">
     <div style="margin:10px;">
      <xsl:for-each select="articles/list">
      <p>
        <b>
            <xsl:value-of select="title"/>
        </b><br/>
        <xsl:value-of select="text" disable-output-escaping="yes"/>
      </p><br/><br/>Количество просмотров: <xsl:value-of select="//content/list_articles/count"/>	
    </xsl:for-each>
      <center><xsl:value-of select="links" disable-output-escaping="yes"/></center>
    </div>
    <xsl:if test="articles/item">
            <xsl:if test="count!=''">
            <span class="tips" title="Статистика за год. Обнуляется в ночь с 31 декабря на 1 января">Количество просмотров:
    <xsl:value-of select="//content/list_articles/count"/></span>

<!-- javascript coding -->
<script>
// execute your scripts when the DOM is ready. this is a good habit
$(function() {



// select all desired input fields and attach tooltips to them
$(".tips").tooltip({

  // place tooltip on the right edge
  position: "center right",

  // a little tweaking of the position
  offset: [-2, 10],

  // use the built-in fadeIn/fadeOut effect
  effect: "fade",

  // custom opacity setting
  opacity: 0.7

});
});
</script></xsl:if>
      <div style="margin:10px;">
        <p>
          <b>
            <xsl:value-of select="articles/item/title"/>
          </b><br/>
          <xsl:value-of select="articles/item/text" disable-output-escaping="yes"/>
        </p>	
        
     </div>
     </xsl:if>
  </xsl:template>
  
  <xsl:template name="map">
        <xsl:for-each select="//section/node/node">
            <xsl:variable name="id" select="node[position()=1]"/>
            <xsl:variable name="level" select="node[position()=2]"/>
            <xsl:variable name="name" select="add/name"/>
            <div class="map">
                <xsl:attribute name="style">padding-left:<xsl:value-of select="$level*10"/>px;</xsl:attribute>
                <a href="?section={$id}" class="submenu_link">
                    <xsl:choose>
                        <xsl:when test="$level=1">
                            <b>
                                <xsl:value-of select="$name"/>
                            </b>
                        </xsl:when>
                        <xsl:otherwise>
                            <xsl:value-of select="$name"/>
                        </xsl:otherwise>
                    </xsl:choose>
                </a>
            </div>
        </xsl:for-each>
    </xsl:template>

  <xsl:template match="news">
    <xsl:choose>
      <xsl:when test="item">
        <p>
          <b>
            <xsl:value-of select="item/date"/>
          </b>
          <br/>
          <xsl:value-of disable-output-escaping="yes" select="item/text"/>
        </p>
      </xsl:when>
      <xsl:when test="archive">
        <xsl:variable name="start">?section=3&amp;</xsl:variable>          
        <div>Архив новостей</div>
        <xsl:for-each select="archive[position()>3]">
          <div class="news_item1"><b><xsl:value-of select="date"/></b><br/>
            <div id="gold"><xsl:value-of select="title"/></div>
            <xsl:value-of select="anons" disable-output-escaping="yes"/>
            <a href="?section=3&amp;item={id}" class="news_button">подробнее<img src="images/news_button.gif" width="21" height="7" alt="Подробнее"/></a>
          </div>
          <xsl:if test="position()!=last()">
            <div class="vert_space">&#160;</div>
          </xsl:if>
        </xsl:for-each>
      </xsl:when>
      <xsl:when test="list">
        <xsl:variable name="start">?section=3&amp;</xsl:variable>          
        <xsl:for-each select="list">
          <div class="news_item1"><b><xsl:value-of select="date"/></b><br/>
            <div id="gold"><xsl:value-of select="title"/></div>
            <xsl:value-of select="anons" disable-output-escaping="yes"/>
            <a href="?section=3&amp;item={id}" class="news_button">подробнее<img src="images/news_button.gif" width="21" height="7" alt="Подробнее"/></a>
          </div>
          <xsl:if test="position()!=last()">
            <div class="vert_space">&#160;</div>
          </xsl:if>
        </xsl:for-each>
      </xsl:when>
    </xsl:choose>
  </xsl:template>
  
  <xsl:template match="find">
    <p>
    <form method="post">
      <input type="text" name="find_text" value="{post}"/> 

      <br/>
      <input type="checkbox" name="precisely">С учетом регистра</input>
      <br/>
      <input type="submit" name="search" value="Искать"/>
    </form>
    </p>
      <xsl:for-each select="node/node">
      <br/><hr/><br/>
        <p>
            <a target="_blank">
              <xsl:attribute name="href">
                <xsl:value-of select="link"/>
              </xsl:attribute>
              <xsl:value-of select="title"/>
            </a>
            <br/>
            <xsl:value-of select="pagetext" disable-output-escaping="yes"/>
            <br/>
            <a target="_blank">
              <xsl:attribute name="href">
                <xsl:value-of select="link"/>
              </xsl:attribute>
              <xsl:value-of select="link"/>
            </a>
            <br/>
        </p>
      </xsl:for-each>
  </xsl:template>

</xsl:stylesheet>
