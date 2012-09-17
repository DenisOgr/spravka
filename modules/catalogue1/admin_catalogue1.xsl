<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	version="1.0">
	<xsl:output indent="yes" />

	<xsl:template match="catalogue1">
		<xsl:variable name="section">
			<xsl:value-of select="section" />
		</xsl:variable>
		<catalogue1>
			<table>
				<sys_messages />
				<!--Список формируем-->
				<!--
					form method="post"> <div class="newline">Заголовок анонса <span
					class="red">*</span>: <input name="anons_title"
					value="{anons/title}" size="80" type="text"/> </div> <div
					class="newline">Текст анонса <span class="red">*</span>:</div> <div
					class="tarea"> <textarea style="width:100%;" name="anons_text"
					rows="40"> <xsl:value-of select="anons/text"
					disable-output-escaping="yes"/> </textarea> </div> <div> <input
					name="save_preview" value="Сохранить" class="submit"
					type="submit"/> </div> </form
				-->

				<xsl:for-each select="item">
					<tr>
						<xsl:variable name="id">
							<xsl:value-of select="id" />
						</xsl:variable>
						<xsl:variable name="picture">
							/uploads/thumb/ct
							<xsl:value-of select="id" />
							_
							<xsl:value-of select="picture_id" />
							_
							<xsl:value-of select="picture_ver" />
							<xsl:value-of select="picture_ext" />
						</xsl:variable>
						<xsl:variable name="large_picture">
							/uploads/ct
							<xsl:value-of select="id" />
							_
							<xsl:value-of select="picture_id" />
							_
							<xsl:value-of select="picture_ver" />
							<xsl:value-of select="picture_ext" />
						</xsl:variable>
						<td>
							<xsl:if test="picture_ver/text()!=''">
								<a href="{$large_picture}" TARGET="_blank">
									<img src="{$picture}" />
								</a>
							</xsl:if>
							&#160;
						</td>
						<td>
							<!--b><xsl:value-of select="name" disable-output-escaping="yes"/></b-->
							<xsl:value-of select="name" disable-output-escaping="yes" />
							<!--xsl:value-of select="price" disable-output-escaping="yes"/> hrn-->
						</td>
						<td>
							<a href="/admin/?section={$section}&amp;edit={$id}"> Правка</a>
						</td>
						<td>
							<a href="/admin/?section={$section}&amp;delete={$id}" onclick="return delete_confirm();">Удалить</a>
						</td>
					</tr>
				</xsl:for-each>
			</table>
			<xsl:if test="edit">
				<xsl:variable name="name">
					<xsl:value-of select="edit/name" />
				</xsl:variable>
				<form method="post" enctype="multipart/form-data">
					<sys_messages />
					<div class="newline">
						Название
						<span class="red">*</span>
						:
						<input name="name" value="{$name}" size="15" type="text" />
					</div>

					<!--
						div class="newline">Краткое описание <span class="red">*</span>:
						<div class="tarea"> <textarea style="width:100%;" name="anons"
						rows="5"> <xsl:value-of select="edit/anons"
						disable-output-escaping="yes"/> </textarea> </div> </div
					-->
					<input type="hidden" name="anons">
						<xsl:value-of select="edit/anons"
							disable-output-escaping="yes" />
					</input>

					<br />
					<div class="newline">Полное описание: </div>
					<div class="tarea">
						<textarea style="width:100%;" name="text" rows="7">
							<xsl:value-of select="edit/text"
								disable-output-escaping="yes" />
						</textarea>
					</div>
					<!--
						xsl:variable name="price"> <xsl:value-of select="edit/price"/>
						</xsl:variable> <div class="newline">Цена товара <span
						class="red">*</span>: <input name="price" value="{$price}"
						size="15" type="text"/><xsl:text> грн.</xsl:text> </div
					-->

					<xsl:for-each select="edit/picture">
						<xsl:variable name="pic_id">
							<xsl:value-of select="id" />
						</xsl:variable>
						<xsl:variable name="pic">
							/uploads/thumb/ct
							<xsl:value-of select="id_goods" />
							_
							<xsl:value-of select="id" />
							_
							<xsl:value-of select="version" />
							<xsl:value-of select="extension" />
						</xsl:variable>
						<xsl:variable name="large_pic">
							/uploads/ct
							<xsl:value-of select="id_goods" />
							_
							<xsl:value-of select="id" />
							_
							<xsl:value-of select="version" />
							<xsl:value-of select="extension" />
						</xsl:variable>
						<div
							style="border: 1px dotted silver; margin: 1px; float: left; width: 150px; height: 150px">
							<div style="float: top">
								<a href="{$large_pic}" TARGET="_blank">
									<img src="{$pic}" />
								</a>
							</div>
							<div>
								<xsl:variable name="sec">
									<xsl:value-of select="../id_section" />
								</xsl:variable>
								<a href="/admin/?section={$sec}&amp;edit={../id}&amp;img_del={$pic_id}"
									onclick="return delete_confirm();">Удалить</a>
							</div>
						</div>
					</xsl:for-each>

					<div class="newline">
						Фотография:
						<input name="userfile" type="file" />
						<input name="save_picture" value="Загрузить" class="submit"
							type="submit" />
					</div>

					
					
					<div class="newline">
						Title<br/>
						<input name="meta_title" value="{edit/meta_title}" style="width:90%"
							type="text" />
					</div>
					<div class="newline">
						Description<br/>
						<textarea style="width:90%;" name="meta_description"
							class="no_editor">
							<xsl:value-of select="edit/meta_description" />
						</textarea>
					</div>
					<div class="newline">
						Keywords<br/>
						<textarea style="width:90%;" name="meta_keywords" class="no_editor">
							<xsl:value-of select="edit/meta_keywords" />
						</textarea>
					</div>
					<div>
						<input name="save" value="Сохранить" class="submit" type="submit" />
						<input name="cancel" value="Отмена" class="submit" type="submit" />
					</div>
				</form>

			</xsl:if>

			<xsl:if test="add_link">

				<p>
					<center>
						<xsl:value-of select="links" disable-output-escaping="yes" />
					</center>
					<a href="/admin/?section={$section}&amp;add"> Добавить наименование</a>
				</p>
			</xsl:if>

		</catalogue1>

	</xsl:template>
</xsl:stylesheet>
