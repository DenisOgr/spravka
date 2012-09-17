<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
  <xsl:output indent="yes"/>
  <xsl:template match="item_articles">
    <form method="post">
      <xsl:attribute name="action">/admin/?section=<xsl:value-of select="section"
          />&amp;edit_item=<xsl:value-of select="node/id"/></xsl:attribute>
      <sys_messages/>
      <xsl:choose>
        <xsl:when test="(options/title='input')">
          <div class="newline">Заголовок статьи<span class="red">*</span>: <input name="title"
            value="{node/title}" size="80" type="text"/>
          </div>
        </xsl:when>
        <xsl:when test="(options/title='textarea')">
          <div class="newline">Заголовок статьи<span class="red">*</span>: </div>
          <div class="tarea">
            <textarea style="width:100%;" name="title" rows="3">
              <xsl:value-of select="node/title" disable-output-escaping="yes"/>
            </textarea>
          </div>
        </xsl:when>
      </xsl:choose>
      
      <xsl:if test="(options/photo='yes')">
        <div class="newline">Загрузка фото для анонса <upload name="art{node/id_section}_{node/id}"
            value="{node/photo}" thumb="yes" width="122" height="86"/>
        </div>
      </xsl:if>
      <xsl:if test="(options/photo='no') and (options/anons='yes') and  not(node/id_section)">
        <div class="newline">
          <font color="red">Загрузить фото для анонса можно только после сохранения основных данных.</font>
          <br/>
        </div>
      </xsl:if>
      <xsl:if test="(options/anons='yes')">
        <div class="newline">Короткий текст <span class="red">*</span>:</div>
        <div class="tarea">
          <textarea style="width:100%;" name="anons" rows="20">
            <xsl:value-of select="node/anons" disable-output-escaping="yes"/>
          </textarea>
        </div>
      </xsl:if>
      <br/>
      <div class="newline">Полный текст:</div>
      <div class="tarea">
        <textarea style="width:100%;" name="text">
          <xsl:value-of select="node/text" disable-output-escaping="yes"/>
        </textarea>
      </div>
      
          <div class="newline">
            Title<br/>
            <input name="meta_title" value="{node/meta_title}" style="width:90%"
              type="text" />
          </div>
          <div class="newline">
            Description<br/>
            <textarea style="width:90%;" name="meta_description"
              class="no_editor">
              <xsl:value-of select="node/meta_description" />
            </textarea>
          </div>
          <div class="newline">
            Keywords<br/>
            <textarea style="width:90%;" name="meta_keywords" class="no_editor">
              <xsl:value-of select="node/meta_keywords" />
            </textarea>
          </div>
      
      
      <div>
        <input name="id" type="hidden" value="{node/id}"/>
        <input name="save_item" value="Сохранить" class="submit" type="submit"/>
        <input name="cancel" value="Отмена" class="submit" type="submit"/>
      </div>
    </form>
  </xsl:template>
</xsl:stylesheet>
