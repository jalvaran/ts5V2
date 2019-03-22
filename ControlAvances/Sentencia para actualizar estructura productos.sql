UPDATE productosventa pv INNER JOIN inventarios_temporal in_t
ON pv.Referencia = in_t.Referencia
SET pv.Departamento = in_t.Departamento,pv.Sub1 = in_t.Sub1,pv.Sub2 = in_t.Sub2,
pv.Sub3 = in_t.Sub3,pv.Sub4 = in_t.Sub4,pv.Sub5 = in_t.Sub5,pv.Sub6 = in_t.Sub6;


UPDATE `facturas_items` fi INNER JOIN productosventa pv ON pv.Referencia=fi.Referencia 
SET fi.`Departamento`=pv.Departamento,fi.`SubGrupo1`=pv.Sub1,fi.`SubGrupo2`=pv.Sub2,
fi.`SubGrupo3`=pv.Sub3,fi.`SubGrupo4`=pv.Sub4,fi.`SubGrupo5`=pv.Sub5;
