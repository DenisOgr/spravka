<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">

  <xsl:template match="question">

    <xsl:for-each select="message">
      <p><b>Вопрос: </b><xsl:value-of select="question"/>&#160;<i> (<xsl:value-of select="name"/>)</i>
        
      </p>
      <p>
      <b>Ответ: </b><xsl:value-of select="answer"/>
      </p>  
      <br/><br/>
    </xsl:for-each>
    
    
    <h2>Задать вопрос</h2>
    <xsl:for-each select="error/node">
      <span class="red">
        <xsl:value-of select="."/><br/>
      </span>
    </xsl:for-each>
    <xsl:if test="message_form">
      <form method="post">
        <table width="90%" border="0">
          <tr>
            <td width="250" valign="bottom">Имя: *</td>
            <td>
              <input name="name" type="text" value="{node/name}" size="50"/>
            </td>
          </tr>
          <tr>
            <td width="250" valign="bottom">e-mail адрес: *</td>
            <td>
              <input name="email" type="text" value="{node/email}" size="50"/>
            </td>
          </tr>
          <tr>
            <td width="250" valign="bottom">Телефон:</td>
            <td>
              <input name="phone" type="text" value="{node/phone}" size="50"/>
            </td>
          </tr>
          <tr>
            <td valign="bottom">Текст сообщения: *</td>
            <td>
              <textarea name="question" cols="38" rows="4">
                <xsl:value-of select="node/question"/>
              </textarea>
            </td>
          </tr>
        <tr>
          <td colspan="2" align="center">
            <input type="submit" name="save" value="Сохранить"/>
          </td>
        </tr>
        </table>
      </form>
    </xsl:if>
    
    


  </xsl:template>

</xsl:stylesheet>
