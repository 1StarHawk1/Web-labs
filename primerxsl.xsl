<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:template match="/">
        <h2>Графические редакторы</h2>
        <table border="1">
            <tr bgcolor="#9acd32">
                <th style="text-align:left">Название</th>
                <th style="text-align:left">Описание</th>
                <th style="text-align:left">Лицензия</th>
                <th style="text-align:left">Поддерживаемые ОС</th>
                <th style="text-align:left">Иконка</th>
            </tr>
            <xsl:for-each select="catalog/cd">
                <tr>
                    <td><xsl:value-of select="name" /></td>
                    <td><xsl:value-of select="description" /></td>
                    <td><xsl:value-of select="license" /></td>
                    <td><xsl:value-of select="os" /></td>
                    <td><xsl:value-of select="image" /></td>
                </tr>
            </xsl:for-each>
        </table>
    </xsl:template>
</xsl:stylesheet>