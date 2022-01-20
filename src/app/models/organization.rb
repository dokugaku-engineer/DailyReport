class Organization < ApplicationRecord
  belongs_to :org_admin

  has_many :user_org_relationships
  has_many :users, through: :user_org_relationships
end
