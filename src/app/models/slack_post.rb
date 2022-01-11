class SlackPost < ApplicationRecord
  belongs_to :user
  validates :text, presence: true, length: { maximum: 3000 }
end
