<?xml version="1.0" encoding="UTF-8"?>

<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
  <xsl:output indent="yes"/>

  <xsl:template match="question">
    <question>

      <xsl:variable name="start">?section=<xsl:value-of select="section"/>&amp;</xsl:variable>
      <xsl:variable name="page"><xsl:value-of select="page"/></xsl:variable>
     <xsl:if test="list">
      <table>
        <xsl:for-each select="list">
          <tr>
            <td>
            <xsl:if test="visible/text()=1">
              <img src="/img/ok.gif" alt="Сообщение видно на клиенте"/>
            </xsl:if>
            </td>
            <td>
                <xsl:value-of select="date"/>
            </td>
            <td>
              <b>
                <xsl:value-of select="question" disable-output-escaping="yes"/>
              </b>
            </td>
            <td>
              <a href="{$start}edit={id}">Редактировать </a>
            </td>
            <td>
              <a href="{$start}delete={id}&amp;" onclick="return delete_confirm();">Удалить </a>
            </td>
          </tr>
        </xsl:for-each>
      </table>
     </xsl:if>

      <xsl:if test="edit">
        <form method="post">
          <sys_messages/>
          <div class="newline">Пользователь:<input name="name" value="{edit/name}" size="80" type="text"/></div>
          <div class="newline">e-mail:<input name="email" value="{edit/email}" size="80" type="text"/></div>
          <div class="newline">Телефон:<input name="phone" value="{edit/phone}" size="80" type="text"/></div>
          <div class="newline">Дата:<input name="date" value="{edit/date}" size="80" type="text"/></div>
          <div class="newline">Вопрос:</div>
          <div class="tarea">
            <textarea style="width:100%;" name="question" rows="10" class="no_editor"> 
              <xsl:value-of select="edit/question" disable-output-escaping="yes"/>
            </textarea>
          </div>
          <div class="newline">Ответ:</div>
          <div class="tarea">
            <textarea style="width:100%;" name="answer" rows="10" class="no_editor"> 
              <xsl:value-of select="edit/answer" disable-output-escaping="yes"/>
            </textarea>
          </div>
          <INPUT NAME="visible" TYPE="checkbox">
            <xsl:if test="edit/visible='1'"><xsl:attribute name="checked"></xsl:attribute></xsl:if>
          </INPUT>
          <div class="newline">Разрешить к отображению на клиенте</div>
          <div>
            <input class="submit" name="save" type="submit" value="Сохранить"/>
          </div>
        </form>
      
      
      </xsl:if>
      <center>
        <xsl:value-of select="links" disable-output-escaping="yes"/>
      </center>
    </question>
  </xsl:template>
</xsl:stylesheet>
