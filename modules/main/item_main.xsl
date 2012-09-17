<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0" xmlns:php="http://php.net/xsl">
    <xsl:output indent="yes"/>
    <xsl:template match="item_main">
        <form action="/admin/?section=1" method="post" enctype="multipart/form-data">
            <sys_messages/>
            <div class="newline">Заголовок <span class="red">*</span>: <input name="title"
                value="{node/title}" size="80" type="text"/>
            </div>
            <div class="newline">Правый верхний угол:</div>
            <div class="tarea">
                <textarea style="width:100%;" name="text" rows="20">
                    <xsl:value-of select="node/text" disable-output-escaping="yes"/>
                </textarea>
            </div>
          
          <div class="newline">Загрузка логотипа
            <upload name="photo1" value="{node/photo1}" />
          </div>
             <xsl:if test="php:function('file_exists', concat(//server_root,'/uploads/music.mp3'))">
          <a class="sm2_button" href="/uploads/music.mp3"/>
          <span style="padding:15px;"><a href="/admin/?section=1&amp;delete_music" style="color:#000;">удалить</a></span>          
          </xsl:if>
          <div class="newline">MP3 файл 
            <input type="file" name="music"/>            
          </div>
          <div class="newline">Ссылка к фотографии: <input name="link1"
            value="{node/link1}" size="80" type="text"/>
          </div>
          <!--div class="newline">Загрузка большой фотографии на главной
            <upload name="photo2" value="{node/photo2}" trumbs="yes" width="400" height="193" />
          </div>
          <div class="newline">Ссылка к фотографии: <input name="link2"
            value="{node/link2}" size="80" type="text"/>
          </div>
          <div class="newline">Слоган: <input name="slogan"
                value="{node/slogan}" size="80" type="text"/>
            </div-->          
            <div class="newline">Копирайт <span class="red">*</span>: <input name="copyright"
                value="{node/copyright}" size="80" type="text"/>
            </div><!--
          <div class="newline">Email <span class="red">*</span>: <input name="email"
            value="{node/email}" size="80" type="text"/>
          </div>          
          --><!--div class="newline">Адрес: <input name="adres"
            value="{node/adres}" size="80" type="text"/>
          </div>          
          <div class="newline">Телефон: <input name="tel"
            value="{node/tel}" size="80" type="text"/>
          </div-->          
            <div>
                <input name="save_item" value="Сохранить" class="submit" type="submit"/>                
            </div>
        </form>
    </xsl:template>
</xsl:stylesheet>
