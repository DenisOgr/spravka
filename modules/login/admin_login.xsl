<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">

  <xsl:template match="login_form">
    <html>
      <head>
        <title>Вход в панель управления</title>
        <link rel="stylesheet" href="/admin.css" type="text/css"/>
      </head>
      <body>        
        <form method="post" enctype="">
          <div style="text-align:center;margin-bottom:15px;"><xsl:call-template name="sys_messages"/></div>
          <table class="table" align="center" style="margin: auto;">
            <tr>
              <th colspan="2">
                <img src="/img/admin_09.gif" width="1" height="26"/>
                <div>Вход в панель управления</div>
              </th>
            </tr>
            <tr>
              <td style="vertical-align:middle;">Логин: </td>
              <td>
                <input type="text" name="login" size="20"/>
              </td>
            </tr>
            <tr>
              <td style="vertical-align:middle;">Пароль: </td>
              <td>
                <input type="password" name="password" size="20"/>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <input type="submit" name="entry" value="Войти" class="submit"/>
              </td>
            </tr>
          </table>
        </form>
      </body>
    </html>
  </xsl:template>
  
  <xsl:template match="change_pass_form">
    <div style="text-align:center;margin-bottom:15px;"><xsl:call-template name="sys_messages"/></div>
    <xsl:if test="not(//node/messages/content/success)">
        <form method="post" enctype="" action="">
          <table class="table" align="center" style="margin: auto;">
            <tr>
              <th colspan="2">
                <img src="/img/admin_09.gif" width="1" height="26"/>
                <div>Смена пароля</div>
              </th>
            </tr>
            <tr>
              <td style="vertical-align:middle;">Новый пароль: </td>
              <td>
                <input type="password" name="password" size="20"/>
              </td>
            </tr>
            <tr>
              <td style="vertical-align:middle;">Повтор пароля: </td>
              <td>
                <input type="password" name="password2" size="20"/>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <input type="submit" name="change_pass" value="Сменить" class="submit"/>
              </td>
            </tr>
          </table>
        </form>
    </xsl:if>
  </xsl:template>
</xsl:stylesheet>
