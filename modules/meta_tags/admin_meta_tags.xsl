<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">

  <xsl:template match="meta_tags">
    <meta_tags>
      <xsl:if test="show_form">
<form method="post">
  <sys_messages/>
  <div class="newline">Title (заголовок окна): <input name="title"
    value="{node/title}" size="70" type="text" maxlength="100"/>
  </div>
  <div class="newline">Description (описание для поисковиков):</div>
  <div class="simply">
    <textarea class="no_editor" style="width:90%;" name="description" rows="5">
      <xsl:value-of select="node/description" disable-output-escaping="yes"/>
    </textarea>
  </div>
  <div class="newline">Keywords (ключевые слова для поисковиков):</div>
  <div class="simply">
    <textarea class="no_editor" style="width:90%;" name="keywords" rows="5">
      <xsl:value-of select="node/keywords" disable-output-escaping="yes"/>
    </textarea>
  </div>
  <div>
    <input name="save" value="Сохранить" class="submit" type="submit"/>                
  </div>





</form>      
      </xsl:if>
    </meta_tags>
  </xsl:template>
  


</xsl:stylesheet>
