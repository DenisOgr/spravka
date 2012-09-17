<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output indent="yes"/>

    <xsl:template match="delivery">
        <xsl:variable name="section">
            <xsl:value-of select="section"/>
        </xsl:variable>
        <delivery>
            <div>
                <sys_messages/>
                <table width="100%" style="margin-top: 5px;">
                    <th>Информация</th>
                    <th>Результат</th>
                    <tr>
                        <td> Всего писем в рассылке: </td>
                        <td>
                            <b>
                                <xsl:value-of select="info/all"/>
                            </b>
                        </td>
                    </tr>
                    <tr>
                        <td>На данный момент отправлено:</td>
                        <td>
                            <b style="color: #0d8513;">
                                <xsl:value-of select="info/send"/>
                            </b>
                        </td>
                    </tr>
                    <tr>
                        <td>Еще осталось отправить:</td>
                        <td>
                            <b style="color: #9d9d9d;">
                                <xsl:value-of select="info/not_send"/>
                            </b>
                        </td>
                    </tr>
                    <tr>
                        <td> Не удалось отправить:</td>
                        <td>
                            <b style="color: #f00; ">
                                <xsl:value-of select="info/error_send"/>
                            </b>
                        </td>
                    </tr>
                </table>
            </div>
            <br/>
            <div id="section">
                <a href="#edit_delivery" onclick="st_show_hide('edit_delivery')">Редактировать текст
                    рассылки</a>

                <div id="edit_delivery" name="edit_delivery">
                    <form method="post">

                        <div class="newline">Тема <span class="red">*</span>: <input name="subject"
                                value="{item/subject}" size="80" type="text"/>
                        </div>
                        <div class="newline">Текст рассылки <span class="red">*</span>: </div>
                        <div class="tarea">
                            <textarea style="width:100%;" name="text">
                                <xsl:value-of select="item/text" disable-output-escaping="yes"/>
                            </textarea>
                        </div>
                        <div>
                            <input name="save" value="Сохранить" class="submit" type="submit"/>
                        </div>
                    </form>
                </div>
                <br/>
                <br/>
                <div style="float: left;">
                    <form method="post" name="form_test_delivery">
                        <input name="test_delivery" type="hidden"/>
                        <a href="#" onclick="document.forms.form_test_delivery.submit();">Тестовая
                            рассылка на свой e-mail </a>
                    </form>
                </div>
                <div style="float: right;" name="st_delivery">
                    <form method="post" name="form_start_delivery">
                        <input name="in_start_delivery" type="hidden" value=""/>
                        <xsl:choose>
                            <xsl:when test="item/text != '' ">
                                <xsl:choose>
                                    <xsl:when test="info/finished = 1">
                                        <a href="#st_delivery"
                                            onclick="w_a_s('Вы уверены что хотите начать новую рассылку?','form_start_delivery','in_start_delivery');"
                                            style="color: #00f;">Начать рассылку</a>
                                    </xsl:when>
                                    <xsl:otherwise>
                                        <a href="#st_delivery"
                                            onclick="w_a_s('Предыдущая рассылка, будет прекращена! Уверены, что хотите начать новую?','form_start_delivery','in_start_delivery');"
                                            style="color: #00f;">Начать рассылку</a>
                                    </xsl:otherwise>
                                </xsl:choose>
                            </xsl:when>
                            <xsl:otherwise>
                                <a href="#st_delivery"
                                    onclick="w_a_s('Внимание убедитесь, что текст рассылки не пустой!','form_start_delivery', '');"
                                    style="color: #00f;">Начать рассылку</a>
                            </xsl:otherwise>
                        </xsl:choose>
                    </form>
                </div>
                <br/>
                <br/>
                <div>
                    <a href="#statistics" onclick="javascript: st_show_hide('statistics');">Статистика отправки
                        рассылки подписчикам [ Показать / Скрыть ]</a>
                </div>

                <div id="statistics" name="statistics" style="display: none; margin-top: 15px;">
                    <xsl:if test="info/error_send > 0">
                        <div align="right">
                            <form method="post" name="form_error_delivery">
                                <input name="error_delivery" type="hidden"/>
                                <a href="#" onclick="document.forms.form_error_delivery.submit();">
                                    Повторная отправка ошибочным e-mail </a>
                            </form>
                        </div>
                    </xsl:if>
                    <table  width="100%" style="margin-top:10px;">
                        <tr>
                            <th>Имя</th>
                            <th>E-mail</th>
                            <th>Статус</th>
                        </tr>
                        <xsl:variable name="_id">0</xsl:variable>
                        <xsl:for-each select="stat">
                            <tr>
                                <td width="20%">
                                    <xsl:value-of select="name"/>
                                </td>
                                <td width="60%">
                                    <xsl:value-of select="email" disable-output-escaping="yes"/>
                                </td>
                                <td width="10%">
                                    <xsl:choose>
                                        <xsl:when test="status = 1">
                                            <img src="../../img/st_ok.gif" alt="Успешно отправлено"
                                                title="Успешно отправлено"/>
                                        </xsl:when>
                                        <xsl:when test="status = 2">
                                            <img src="../../img/st_error.gif"
                                                alt="Ошибка при передаче"
                                                title="Ошибка при передаче"/>
                                        </xsl:when>
                                        <xsl:otherwise>
                                            <img src="../../img/st_not_send.gif" alt="Не отправлено"
                                                title="Не отправлено"/>
                                        </xsl:otherwise>
                                    </xsl:choose>
                                </td>
                            </tr>
                        </xsl:for-each>
                    </table>
                </div>
            </div>
        </delivery>
    </xsl:template>
</xsl:stylesheet>
