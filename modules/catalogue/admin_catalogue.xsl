<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	version="1.0">
	<xsl:output indent="yes" />

	<xsl:template match="catalogue">
		<xsl:variable name="section">
			<xsl:value-of select="section" />
		</xsl:variable>
		<catalogue>
			<table>
				<!--Список формируем-->
				<!--xsl:if test="item"-->
				<xsl:if test="not(edit) and not(names)">
					<form method="post">
						<sys_messages />
						<!--
							div class="newline">Заголовок анонса <span class="red">*</span>:
							<input name="anons_title" value="{anons/title}" size="80"
							type="text"/> </div
						-->
						<div class="newline">Текст анонса:</div>
						<div class="tarea">
							<textarea style="width:100%;" name="anons_text" rows="10">
								<xsl:value-of select="anons/text"
									disable-output-escaping="yes" />
							</textarea>
						</div>
						<div>
							<input name="save_preview" value="Сохранить" class="submit"
								type="submit" />
						</div>
					</form>
					<!--/xsl:if-->
				</xsl:if>
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
							<xsl:value-of select="name" />
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
				<form method="post" enctype="multipart/form-data">
					<sys_messages />
					<table border="0" width="100%">
						<tr>
							<td width="20%">
								Название
								<span class="red">*</span>
								:
							</td>
							<td>
								<input name="name" value="{edit/name}" size="45" type="text" />
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<div class="newline">Описание: </div>
								<div class="tarea">
									<textarea style="width:100%;" name="text" rows="21">
										<xsl:value-of select="edit/text"
											disable-output-escaping="yes" />
									</textarea>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								Адресс
              </td>
							<td>
								<input name="adres" value="{edit/adres}" size="45" type="text" />
							</td>
						</tr>
						<tr>
							<td>
								Телефон
              </td>
							<td>
								<input name="tel" value="{edit/tel}" size="45" type="text" />
							</td>
						</tr>
						<tr>
							<td>
								Телефон (моб.)
              </td>
							<td>
								<input name="tel_mob" value="{edit/tel_mob}" size="45"
									type="text" />
							</td>
						</tr>
						<tr>
							<td>
								Email
              </td>
							<td>
								<input name="email" value="{edit/email}" size="45" type="text" />
							</td>
						</tr>
						<tr>
							<td>
								URL
              </td>
							<td>
								<input name="url" value="{edit/url}" size="45" type="text" />
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<div class="newline">Дополнительно: </div>
								<div class="tarea">
									<textarea style="width:100%;" name="more" rows="21">
										<xsl:value-of select="edit/more"
											disable-output-escaping="yes" />
									</textarea>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								Title
              </td>
							<td>
								<input name="meta_title" value="{edit/meta_title}" size="45" type="text" style="width:90%;"/>
							</td>
						</tr>
						<tr>
							<td>
								Description
              </td>
							<td>
								<textarea style="width:90%;" name="meta_description" class="no_editor">
									<xsl:value-of select="edit/meta_description"/>
								</textarea>
							</td>
						</tr>
						<tr>
							<td>
								Keywords
              </td>
							<td>
								<textarea style="width:90%;" name="meta_keywords" class="no_editor">
									<xsl:value-of select="edit/meta_keywords"/>
								</textarea>
							</td>
						</tr>
					</table>
					<br />
					<!--
						div class="newline">Полное описание: </div> <div class="tarea">
						<textarea style="width:100%;" name="text" rows="7"> <xsl:value-of
						select="edit/text" disable-output-escaping="yes"/> </textarea>
						</div
					-->
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

		</catalogue>

	</xsl:template>
</xsl:stylesheet>
