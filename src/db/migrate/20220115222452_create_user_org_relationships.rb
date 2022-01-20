class CreateUserOrgRelationships < ActiveRecord::Migration[6.1]
  def change
    create_table :user_org_relationships do |t|
      t.references :user, null: false, foreign_key: true
      t.references :organization, null: false, foreign_key: true

      t.timestamps

      t.index [:user_id, :organization_id], unique: true
    end
  end
end
