UPDATE productosventa pv INNER JOIN inventarios_temporal in_t
ON pv.Referencia = in_t.Referencia
SET pv.Departamento = in_t.Departamento,pv.Sub1 = in_t.Sub1,pv.Sub2 = in_t.Sub2,
pv.Sub3 = in_t.Sub3,pv.Sub4 = in_t.Sub4,pv.Sub5 = in_t.Sub5,pv.Sub6 = in_t.Sub6;
