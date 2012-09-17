<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output indent="yes"/>

    <xsl:template name="delivery">
        <xsl:variable name="section">
            <xsl:value-of select="//content/delivery/section"/>
        </xsl:variable>
      
        <form method="post" name="form_delivery">          
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><div><img src="images/pic_zakaz.jpg" width="77" height="72" align="absmiddle"/><span class="podpiska">ПОДПИСКА НА НОВОСТИ</span></div></td>
          </tr>
          <tr>
            <td valign="baseline"><table width="100%" border="0" cellspacing="2" cellpadding="0">
              <tr>
                <td><div class="podpiska_pole"> 
                    <label>
                      Ваше имя &#160;&#160;&#160;<input type="text" name="name"/>
                    </label>
                </div></td>
              </tr>
              <tr>
                <td><div class="podpiska_pole">
                    <label> Ваш E-mail&#160;
                      <input type="text" name="email"/>
                    </label>
                </div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <input type="hidden" name="section" value="{$section}"/>
            <input type="hidden" name="delivery" value="on"/>            
            <td align="right"><a href="#" onclick="document.forms.form_delivery.delivery.value='on'; document.forms.form_delivery.submit();" class="pod_otpis">                    Подписаться &gt;&gt;</a><br/>
              <br/>
              <a href="#" onclick="document.forms.form_delivery.delivery.value='off'; document.forms.form_delivery.submit();" class="pod_otpis">Отменить подписку &gt;&gt;</a></td>
          </tr>
        </table>
        </form>
    </xsl:template>
</xsl:stylesheet>
