<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
  <xsl:output indent="yes"/>

  <xsl:template match="rss">
    <xsl:variable name="section">
      <xsl:value-of select="section"/>
    </xsl:variable>
    <rss>

      <xsl:choose>
        <xsl:when test="item">
          <form method="post">
            <sys_messages/>
            <div class="newline">Вы редактируете канал rss: <xsl:value-of select="//rss/item/url"
                disable-output-escaping="yes"/>
            </div>
            <div class="newline">Название rss канала <span class="red">*</span>: <input name="name"
                value="{item/name}" size="30" type="text"/>
            </div>
            <div class="newline">Url <span class="red">*</span>: <input name="url"
                value="{item/url}" size="80" type="text"/>
            </div>
            <div>
              <input name="save" value="Сохранить" class="submit" type="submit"/>
            </div>
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
                    <xsl:value-of select="name" disable-output-escaping="yes"/> &#160; </td>
                  <td>
                    <a href="/admin/?section={$section}&amp;edit={$id}"> Правка</a>
                  </td>
                  <td>
                    <a href="/admin/?section={$section}&amp;delete={$id}"
                      onclick="return delete_confirm();">Удалить</a>
                  </td>
                </tr>
              </xsl:if>
            </xsl:for-each>
          </table>
          <a href="/admin/?section={$section}&amp;add"> Добавить наименование</a>
        </xsl:when>
      </xsl:choose>


    </rss>

  </xsl:template>
</xsl:stylesheet>
