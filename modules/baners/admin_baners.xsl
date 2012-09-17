<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
  <xsl:output indent="yes"/>

  <xsl:template match="baners">
    <xsl:variable name="section">
      <xsl:value-of select="section"/>
    </xsl:variable>
    <baners>

      <!--Список формируем-->
      <xsl:choose>
        <xsl:when test="item">
          <form method="post">
            <sys_messages/>
            <div class="newline">Вы меняете кнопку <xsl:value-of select="//baners/item/url" disable-output-escaping="yes"/>
            </div>
            <div class="newline">Новая кнопка <span class="red">*</span>:</div>
            <textarea class="no_editor" style="width:100%;" name="url" rows="10">
              <xsl:value-of select="//baners/item/url"/>
            </textarea>
            <div>
              <input name="save" value="Сохранить" class="submit" type="submit"/>
            </div>
            <!--div>
              <input name="reset" value="Очистить" class="submit" type="reset"/>                
            </div-->
          </form>
        </xsl:when>
        
        <xsl:when test="list">
          <table border="0">
            <xsl:for-each select="list">
              <xsl:if test="id/text()!=''">
              <tr>
                <xsl:variable name="id">
                  <xsl:value-of select="id"/>
                </xsl:variable>
                <td>
                  <xsl:value-of select="url" disable-output-escaping="yes"/> &#160; </td>
                <td>
                  <a href="/admin/?section={$section}&amp;edit={$id}"> Правка</a>
                </td>
                <td>
                  <a href="/admin/?section={$section}&amp;delete={$id}" onclick="return delete_confirm();">Удалить</a>
                </td>
              </tr>
              </xsl:if>
            </xsl:for-each>
          </table>
          <a href="/admin/?section={$section}&amp;add"> Добавить наименование</a>
        </xsl:when>
      </xsl:choose>


    </baners>

  </xsl:template>
</xsl:stylesheet>
