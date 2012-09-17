<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output indent="yes"/>
    <xsl:template match="item_news">
        <news>
            <form method="post">
                <sys_messages/>


              <div class="newline">Название <span class="red">*</span>: <input name="title"
                value="{node/title}" size="15" type="text"/>
              </div>              
                <div class="newline">Дата <span class="red">*</span>: <input name="date"
                  size="15" type="text">
                  <xsl:choose>
                    <xsl:when test="node/date">
                      <xsl:attribute name="value"><xsl:value-of select="node/date"/></xsl:attribute>
                    </xsl:when>
                    <xsl:otherwise>
                      <xsl:attribute name="value"><xsl:value-of select="today"/></xsl:attribute>                      
                    </xsl:otherwise>
                  </xsl:choose>                  
                </input>
                </div>
                <div class="newline">Краткий текст новости: <span class="red">*</span>: <div
                        class="tarea">
                        <textarea style="width:100%;" name="anons" rows="5">
                            <xsl:value-of select="node/anons" disable-output-escaping="yes"/>
                        </textarea>
                    </div>
                </div>
                <br/>
                <div class="newline">Полный текст новости:</div>
                <div class="tarea">
                    <textarea style="width:100%;" name="text">
                        <xsl:value-of select="node/text" disable-output-escaping="yes"/>
                    </textarea>
                </div>
                <div>
                    <input name="save_item" value="Сохранить" class="submit" type="submit"/>
                    <input name="cancel" value="Отмена" class="submit" type="submit"/>
                </div>
            </form>
        </news>
    </xsl:template>
</xsl:stylesheet>
