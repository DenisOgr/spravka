<?xml version="1.0" encoding="UTF-8"?>

<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0" xmlns:php="http://php.net/xsl">
	<xsl:output indent="yes" />
	<xsl:include href="../../engine/xsl/templates.xsl" />

	<xsl:template match="list_comments">
		<comments>
			<xsl:variable name="start">
				/admin/?section=
				<xsl:value-of select="section" />
				&amp;
			</xsl:variable>
			<xsl:if test="node">
				<table class="table">
					<tr>
						<th style="padding:6px;">Дата добавления</th>
						<th style="padding:6px;">Аватар</th>
						<th style="padding:6px;">Имя</th>
						<th style="padding:6px;">Текст</th>
						<th style="padding:6px;" colspan="3"></th>
					</tr>
					<xsl:for-each select="node">
						<tr>
							<td>
								<xsl:value-of select="date_add" />
							</td>
							<td>                
                <img src="{photo}" width="50"/>
              </td>
							<td>
								<xsl:value-of select="concat(first_name,' ',last_name)" />				
							</td>
							<td>
								<xsl:value-of select="text" />
							</td>
							<td>
								<xsl:if test="active=0">
									<a href="{$start}active_item={id}"> Активировать </a>
								</xsl:if>
							</td>
							<td>
								<a href="{$start}edit_item={id}"> Редактировать </a>
							</td>
							<td>
								<a href="{$start}delete_item={id}" onclick="return delete_confirm();">
									Удалить
								</a>
							</td>
						</tr>
					</xsl:for-each>
				</table>
			</xsl:if>
			<br />
			<!-- <a href="{$start}add"> Добавить комментарий</a> -->
		</comments>
	</xsl:template>
</xsl:stylesheet>
