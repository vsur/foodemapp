SELECT
	participants_codes.id AS 'id',
	participants_codes.participant_id,
    participants_codes.vizvar,
	participants_codes.code_id,
    codes.name AS 'code.name',
    codes.description AS 'code.description',
    field_types.id AS 'field_types.id',
    field_types.name AS 'field_types.name',
    participants_codes.created,
    participants_codes.modified

FROM participants_codes

LEFT JOIN codes ON participants_codes.code_id=codes.id
LEFT JOIN field_types ON codes.field_type_id=field_types.id

ORDER BY participants_codes.id ASC;