<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:php="http://php.net/xsl" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:output encoding="utf-8" indent="yes" media-type="text/xhtml" method="html"/>

  <xsl:template match="links">
    <xsl:variable name="section">
      <xsl:value-of select="section"/>
    </xsl:variable>
    <links>
      <xsl:variable name="img">/uploads/</xsl:variable>
      <!-- Тут будет находиться описание шаблона для отображения секций-->
      <xsl:if test="links_section">
        <div class="newline" style="padding-top: 0px; padding-bottom: 0px;">
          <a href="/admin/?section={$section}&amp;links_section_add">
            <img border="0" src="/img/new.gif" title="Добавить новый раздел"/>
          </a>
          <xsl:if test="links_section_add/text()=''">
            <form method="post">
              <input type="hidden" name="level" value="1"/>
              <input type="text" name="links_section_name" size="40"/>&#160; <input type="submit" name="links_section_save" value="Добавить" class="submit"/>
            </form>
          </xsl:if>
        </div>

        <xsl:for-each select="links_section/node">
          <xsl:variable name="identetion">
            <xsl:value-of select="level *18"/>
          </xsl:variable>
          <xsl:variable name="id">
            <xsl:value-of select="id"/>
          </xsl:variable>
          <xsl:variable name="level">
            <xsl:value-of select="level+1"/>
          </xsl:variable>
          <xsl:variable name="name">
            <xsl:value-of select="name"/>
          </xsl:variable>
          <div>
            <a href="/admin/?section={$section}&amp;links_section_add={$id}">
              <img border="0" src="/img/new.gif" title="Добавить подраздел"/>
            </a>
            <a href="/admin/?section={$section}&amp;links_section_edit={$id}">
              <img border="0" src="/img/edit.gif" title="Переименовать подраздел"/>
            </a>
            <a href="/admin/?section={$section}&amp;links_section_del={$id}" onclick="return delete_confirm();">
              <img border="0" src="/img/delete.gif" title="Удалить раздел"/>
            </a>
            <a href="/admin/?section={$section}&amp;links_section={$id}" style="text-decoration: none; color:#727272; margin-left: {$identetion}px; padding-top: 0px; padding-bottom: 0px;">
              <xsl:value-of select="name"/>
            </a>
            <br/>
            <xsl:choose>
              <xsl:when test="../../links_section_add=$id">
                <form method="post">
                  <input type="hidden" name="id_parent" value="{$id}"/>
                  <input type="hidden" name="level" value="{$level}"/>
                  <input type="text" name="links_section_name" size="40"/>&#160; <input type="submit" name="links_section_save" value="Добавить" class="submit"/>
                </form>
              </xsl:when>
              <xsl:when test="../../links_section_edit=$id">
                <form method="post">
                  <input type="text" name="links_section_name" size="40" value="{$name}"/>&#160; <input type="submit" name="links_section_update" value="Сохранить" class="submit"/>
                </form>
              </xsl:when>
            </xsl:choose>
          </div>
        </xsl:for-each>
      </xsl:if>
      <!-- Тут будет находиться описание шаблона для отображения ССЫЛОК для определенной секции-->
      <xsl:if test="detail_links_section">
        <xsl:if test="detail_links_section/links_section_path">
          <a href="/admin/?section={$section}">Каталог</a>  
          <xsl:for-each select="detail_links_section/links_section_path/node">
            <xsl:variable name="path_id">
              <xsl:value-of select="id"/>
            </xsl:variable> &gt;&gt; 
            <a href="/admin/?section={$section}&amp;links_section={$path_id}">
              <xsl:value-of select="name"/>
            </a></xsl:for-each>

          <xsl:variable name="links_section_id">
            <xsl:value-of select="links_section_name/id"/>
          </xsl:variable>
          &#160;&#160;&#160;&#160;&lt;--<a href="/admin/?section={$section}&amp;links_add={$links_section_id}">Добавить ссылку</a>--&gt; <br/><br/>
        </xsl:if>

        <xsl:for-each select="detail_links_section">
          <xsl:variable name="url">
            <xsl:value-of select="url"/>
          </xsl:variable>
          <a href="{$url}" target="blank">
            <xsl:value-of select="title"/>
          </a>
          <!--xsl:variable name="image_id">link_<xsl:value-of select="image"/></xsl:variable>
          <xsl:variable name="attribute">border="0"</xsl:variable>
          <xsl:copy-of select="php:function('Files::show_image','{$image_id}','',string(main/{$image_id}), string($attribute))"/-->
          <xsl:if test="description/text()!=''">
          <div style="padding-left: 20px;">
            <xsl:value-of select="description"/>
          </div></xsl:if>
          <div class="nelwline"><a href="/admin/?section={$section}&amp;del_link={id}&amp;links_section={id_section}" onclick="return delete_confirm();">Удалить</a>&#160;&#160; 
            <a href="/admin/?section={$section}&amp;links_edit={id}">Править</a></div>
          <br/>          <br/>
        </xsl:for-each>
      </xsl:if>
      <xsl:if test="show_add_links_form">
        <form method="post">
          <div class="newline">URL:</div>
          <input type="text" size="50" name="url" value="{my_url}"/>
          <input class="submit" type="submit" name="get_info" value="Get info"/>
          <div class="newline">Заголовок: </div>
          <input type="text" size="50" name="title" value="{my_title}"/>
          <div class="newline">Описание: </div>
          <input type="text" size="50" name="description" value="{my_description}"/>
          <div class="newline">Изображение: </div>
          <input name="image" type="radio" value="url"/>Кодом<br/> 
          <input name="image" type="radio" value="img"/>Картинкой<br/>
          <input name="image" type="radio" value="тщ"/>Без картинки<br/>
          <upload name="link_{current_links_section}" value="{node/photo1}" thumb="yes" width="207" height="110"/>
          <div class="newline">Код картинки (если есть): <textarea rows="5" cols="50" class="no_editor"></textarea></div>
          <div class="newline"><input class="submit" type="submit" name="save_link" value="Сохранить"/></div>
        </form>
      </xsl:if>
    </links>
  </xsl:template>

</xsl:stylesheet>
