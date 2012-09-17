<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output indent="yes"/>
    <xsl:include href="../../lib/xsl/templates.xsl"/>
    <xsl:template name="registration">
        <xsl:choose>
            <xsl:when test="content/registration='send'">
                <div style="text-align:center;">
                <xsl:call-template name="sys_messages"/>
                    </div>
            </xsl:when>
            <xsl:otherwise>
                <div style="text-align:center;">
                    <p>
                        <xsl:call-template name="sys_messages"/>
                    </p>
                    <p> Запись производиться не менее чем за 1 день до Вашего визита.</p>
                    
                </div>
                <form method="post">

                    <table>
                        <tr>
                            <th width="50%">Ф.И.О. <span class="red">*</span>:</th>
                            <td>
                                <input type="text" name="name" size="30"
                                    value="{content/registration/name}"/>
                            </td>
                        </tr>
                        <tr>
                            <th>Контактный телефон <span class="red">*</span>:</th>
                            <td>
                                <input type="text" name="phone" size="30"
                                    value="{content/registration/phone}"/>
                            </td>
                        </tr>
                        <tr>
                            <th>Услуга <span class="red">*</span>:</th>
                            <td>
                                <label>
                                    <input type="radio" name="service" value="1">
                                        <xsl:if test="content/registration/service=1">
                                            <xsl:attribute name="checked"/>
                                        </xsl:if>
                                    </input>консультация</label>
                                <br/>
                                <label><input type="radio" name="service" value="2">
                                        <xsl:if test="content/registration/service=2">
                                            <xsl:attribute name="checked"/>
                                        </xsl:if>
                                    </input>лечение</label>
                                <br/>
                                <label><input type="radio" name="service" value="3">
                                        <xsl:if test="content/registration/service=3">
                                            <xsl:attribute name="checked"/>
                                        </xsl:if>
                                    </input>удаление</label>
                                <br/>
                                <label><input type="radio" name="service" value="4">
                                        <xsl:if test="content/registration/service=4">
                                            <xsl:attribute name="checked"/>
                                        </xsl:if>
                                    </input>протезирование</label>
                                <br/>
                                <label><input type="radio" name="service" value="5">
                                        <xsl:if test="content/registration/service=5">
                                            <xsl:attribute name="checked"/>
                                        </xsl:if>
                                    </input>имплантация</label>
                                <br/>
                            </td>
                        </tr>
                        <tr>
                            <th>Укажите день и время на которые хотели бы записаться на прием <span
                                    class="red">*</span>:</th>
                            <td>
                                <input type="text" name="date" size="6" value="{content/registration/date}"/>
                                (ДД.ММ.ГГГГ) <input type="text" name="hour" size="1" value="{content/registration/hour}"/>:<input type="text" name="minute" size="1" value="{content/registration/minute}"/> (ЧЧ:MM)</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align:center; padding:5px;">
                                <input type="submit" name="send" value="Отправить запрос"/>
                            </td>
                        </tr>
                    </table>
                </form>
            </xsl:otherwise>
        </xsl:choose>

    </xsl:template>
</xsl:stylesheet>
