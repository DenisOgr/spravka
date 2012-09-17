<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
  <xsl:output indent="yes"/>

  <xsl:template match="messages">
    <xsl:if test="error">
      <font color="red">Ошибка: <xsl:value-of select="error"/></font><br/><br/>
    </xsl:if>
    <xsl:if test="not(request=1)">
      <xsl:if test="//section/node/current_id=39">
      <br/><p class="btext">Заказать услугу/задать вопрос</p><br/><br/>     
      <div style="font-size: 12px; font-family: Tahoma;" align="justify">
        <form method="post" action="?section=39&amp;request" ENCTYPE="multipart/form-data">
          <table align="left">
            <tr>
              <td>Ф.И.О. контактного лица</td>
              <td>
                <input type="text" value="{request_add/fio}" name="fio"/>
              </td>
            </tr>
            <tr>
              <td>Телефон:</td>
              <td>
                <input type="text" value="{request_add/tel}" name="tel"/>
              </td>
            </tr>
            <tr>
              <td>E-mail:</td>
              <td>
                <input type="text" value="{request_add/email}" name="email"/>
              </td>
            </tr>
            <tr>
              <td>Вопрос:</td>            
              <td>
                <textarea rows="3" cols="40" name="question"><xsl:value-of select="request_add/question"/>&#160;</textarea>
              </td>
            </tr>
            <tr>
              <td colspan="2" style="text-align:center; padding:5px;">
                <input type="submit" name="send_re" size="40" value="Отправить"/>
              </td>
            </tr>
          </table>
        </form>
      </div>
      </xsl:if>
      
      <xsl:if test="//section/node/current_id=40">
        <br/><p class="btext">Заявка на подбор персонала</p><br/><br/>     
        <div style="font-size: 12px; font-family: Tahoma;" align="justify">
          <form method="post" action="?section=40&amp;request" ENCTYPE="multipart/form-data">
            <table align="left">
              <tr>
                <td>Контактное лицо для обсуждения заказа (ФИО):<span style="color:red;">*</span></td>
                <td>
                  <input type="text" value="{request_add/pole1}" name="pole1"/>
                </td>
              </tr>
              <tr>
                <td>Должность:<span style="color:red;">*</span></td>
                <td>
                  <input type="text" value="{request_add/pole2}" name="pole2"/>
                </td>
              </tr>
              <tr>
                <td>Компания:<span style="color:red;">*</span></td>
                <td>
                  <input type="text" value="{request_add/pole3}" name="pole3"/>
                </td>
              </tr>
              <tr>
                <td>Направление деятельности:</td>
                <td>
                  <input type="text" value="{request_add/pole4}" name="pole4"/>
                </td>
              </tr>
              <tr>
                <td>Адрес:</td>
                <td>
                  <input type="text" value="{request_add/pole5}" name="pole5"/>
                </td>
              </tr>
              <tr>
                <td>Тел./Факс:<span style="color:red;">*</span></td>
                <td>
                  <input type="text" value="{request_add/pole6}" name="pole6"/>
                </td>
              </tr>
              <tr>
                <td>e-mail:</td>
                <td>
                  <input type="text" value="{request_add/pole7}" name="pole7"/>
                </td>
              </tr>
              <tr>
                <td>web-сайт:</td>
                <td>
                  <input type="text" value="{request_add/pole8}" name="pole8"/>
                </td>
              </tr>
              <tr>
                <td>Вакансия:<span style="color:red;">*</span></td>
                <td>
                  <input type="text" value="{request_add/pole9}" name="pole9"/>
                </td>
              </tr>
              <tr>
                <td>Должностные обязанности:</td>            
                <td>
                  <textarea rows="3" cols="40" name="pole10"><xsl:value-of select="request_add/pole10"/>&#160;</textarea>
                </td>
              </tr>
              <tr>
                <td>Уровень образования:</td>
                <td>
                  <input type="text" value="{request_add/pole11}" name="pole11"/>
                </td>
              </tr>
              <tr>
                <td>Возраст:</td>
                <td>
                  <input type="text" value="{request_add/pole12}" name="pole12"/>
                </td>
              </tr>
              <tr>
                <td>Иностранные языки:</td>
                <td>
                  <input type="text" value="{request_add/pole13}" name="pole13"/>
                </td>
              </tr>
              <tr>
                <td>Проффесиональные навыки:</td>            
                <td>
                  <textarea rows="3" cols="40" name="pole14"><xsl:value-of select="request_add/pole14"/>&#160;</textarea>
                </td>
              </tr>
              <tr>
                <td>Дополнительные требования:</td>            
                <td>
                  <textarea rows="3" cols="40" name="pole15"><xsl:value-of select="request_add/pole15"/>&#160;</textarea>
                </td>
              </tr>
              <tr>
                <td>Размер оплаты труда (оклад) + бонусы, премии, %</td>
                <td>
                  <input type="text" value="{request_add/pole16}" name="pole16"/>
                </td>
              </tr>
              <tr>
                <td>Дополнительная информация:</td>            
                <td>
                  <textarea rows="3" cols="40" name="pole17"><xsl:value-of select="request_add/pole17"/>&#160;</textarea>
                </td>
              </tr>
              <tr>
                <td colspan="2" style="text-align:center; padding:5px;">
                  <input type="submit" name="send2" size="40" value="Отправить"/>
                </td>
              </tr>
            </table>
          </form>
        </div>
      </xsl:if>
      
    </xsl:if>
    <xsl:if test="success">
      <p style="margin:50px 0px 50px 0px;"><font color="green"><xsl:value-of select="success"/></font></p>
    </xsl:if>
  </xsl:template>
  
</xsl:stylesheet>
